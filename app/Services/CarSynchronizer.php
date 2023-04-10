<?php

namespace App\Services;

use App\Models\Catcher;
use App\Models\Vehicle;
use App\Models\VehicleConstructor;
use App\Models\VehicleModel;
use App\Models\VehicleSpecification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class CarSynchronizer
{
    protected string $path;
    protected array $rows;
    

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->rows = [];
    }

    

    public function sync()
    {
        $this->getRowsFromPath();
        $currentUrls = Vehicle::get()->pluck('url')->all();

        foreach ($this->rows as $row) {
            $constructor = $this->getVehicleConstructor($row['constructor']);
            $vehicleModel = $this->getVehicleModel($row['catchers']['model'], $constructor);
            $vehicleSpecification = $this->getVehicleSpecification($row['catchers']['specification'], $vehicleModel);
            
            if (!in_array($row['source_url'], $currentUrls)) {
                Vehicle::create([
                    'vehicle_constructor_id' => $constructor->id,
                    'vehicle_model_id' => $vehicleModel->id,
                    'vehicle_specification_id' => $vehicleSpecification ? $vehicleSpecification->id : null,
                    'designation' => $row['designation'],
                    'url' => $row['source_url']
                ]);
            }
        }
    }

    private function getRowsFromPath()
    {
        $file = Storage::get($this->path);

        if ($file) {
            $content = json_decode($file, true);
            $this->rows = $content['data'];
        }
    }

    private function getVehicleConstructor(string $catcherString): VehicleConstructor
    {
        $constructor = VehicleConstructor::whereHas('catchers', function (Builder $query) use ($catcherString) {
            $query->where('designation', $catcherString);
        })->first();

        if (!$constructor) {
            $constructor = VehicleConstructor::create([
                'designation' => ucwords($catcherString),
                'slug' => Str::slug($catcherString)
            ]);

            $constructor->catchers()->save(
                new Catcher(['designation' => $catcherString])
            );
        }

        return $constructor;
    }

    private function getVehicleModel(array $catcher, VehicleConstructor $constructor): VehicleModel
    {
        $vehicleModel = $constructor->vehicleModels()->whereHas('catchers', function (Builder $query) use ($catcher) {
            $query->where('designation', $catcher['code']);
        })->first();

        if (!$vehicleModel) {
            $vehicleModel = VehicleModel::create([
                'vehicle_constructor_id' => $constructor->id,
                'designation' => ucwords($catcher['label']),
                'slug' => Str::slug($catcher['label'])
            ]);

            $vehicleModel->catchers()->save(
                new Catcher(['designation' => $catcher['code']])
            );
        }

        return $vehicleModel;
    }

    private function getVehicleSpecification(array $catcher, VehicleModel $vehicleModel): VehicleSpecification
    {
        $vehicleSpecification = $vehicleModel->vehicleSpecifications()->whereHas('catchers', function (Builder $query) use ($catcher) {
            $query->where('designation', $catcher['code']);
        })->first();

        if (!$vehicleSpecification) {
            $vehicleSpecification = VehicleSpecification::create([
                'vehicle_constructor_id' => $vehicleModel->vehicle_constructor_id,
                'vehicle_model_id' => $vehicleModel->id,
                'designation' => ucwords($catcher['label']),
                'slug' => Str::slug($catcher['label'])
            ]);

            $vehicleSpecification->catchers()->save(
                new Catcher(['designation' => $catcher['code']])
            );
        }

        return $vehicleSpecification;
    }
}
