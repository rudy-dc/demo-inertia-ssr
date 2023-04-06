<?php

namespace App\Services;

use App\Models\Catcher;
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

        foreach ($this->rows as $row) {
            $constructor = $this->getVehicleConstructor($row['constructor']);
            $vehicleModel = $this->getVehicleModel($row['model_expanded'], $constructor);
            
            if ($row['specification']) {
                $this->getVehicleSpecification($row['specification'], $vehicleModel);
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

    private function getVehicleModel(string $catcherString, VehicleConstructor $constructor): VehicleModel
    {
        $vehicleModel = $constructor->vehicleModels()->whereHas('catchers', function (Builder $query) use ($catcherString) {
            $query->where('designation', $catcherString);
        })->first();

        if (!$vehicleModel) {
            $vehicleModel = VehicleModel::create([
                'vehicle_constructor_id' => $constructor->id,
                'designation' => ucwords($catcherString),
                'slug' => Str::slug($catcherString)
            ]);

            $vehicleModel->catchers()->save(
                new Catcher(['designation' => $catcherString])
            );
        }

        return $vehicleModel;
    }

    private function getVehicleSpecification(string $catcherString, VehicleModel $vehicleModel): VehicleSpecification
    {
        $vehicleSpecification = $vehicleModel->vehicleSpecifications()->whereHas('catchers', function (Builder $query) use ($catcherString) {
            $query->where('designation', $catcherString);
        })->first();

        if (!$vehicleSpecification) {
            $vehicleSpecification = VehicleSpecification::create([
                'vehicle_constructor_id' => $vehicleModel->vehicle_constructor_id,
                'vehicle_model_id' => $vehicleModel->id,
                'designation' => ucwords($catcherString),
                'slug' => Str::slug($catcherString)
            ]);

            $vehicleSpecification->catchers()->save(
                new Catcher(['designation' => $catcherString])
            );
        }

        return $vehicleSpecification;
    }
}
