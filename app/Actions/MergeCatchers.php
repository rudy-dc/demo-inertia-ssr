<?php

namespace App\Actions;

use App\Models\Catcher;
use App\Models\Vehicle;
use App\Models\VehicleSpecification;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Str;

class MergeCatchers
{
    use AsAction;

    public function handle(Collection $collection, $newLabel)
    {

        $catchersToMerge = [];
        $vehicleModel = $collection[0]->vehicleModel;

        foreach ($collection as $item) {
            $catchersToMerge = array_merge($catchersToMerge, $item->catchers()->get()->pluck('designation')->all());
            $item->catchers()->delete();
            $item->update(['is_visible' => false]);
        }

        $vehicleSpecification = VehicleSpecification::create([
            'vehicle_constructor_id' => $vehicleModel->vehicle_constructor_id,
            'vehicle_model_id' => $vehicleModel->id,
            'designation' => ucwords($newLabel),
            'slug' => Str::slug($newLabel)
        ]);

        foreach ($catchersToMerge as $catcher) {
            $vehicleSpecification->catchers()->save(
                new Catcher(['designation' => $catcher])
            );
        }

        Vehicle::whereIn('vehicle_specification_id', $collection->pluck('id')->all())->update(['vehicle_specification_id' => $vehicleSpecification->id]);

    }
}
