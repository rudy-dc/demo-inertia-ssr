<?php

namespace App\Http\Controllers;

use App\Models\VehicleConstructor;
use App\Models\VehicleModel;
use App\Models\VehicleSpecification;
use Inertia\Inertia;

class PageController extends Controller
{
    public function dashboard()
    {
        $vehicleConstructors = VehicleConstructor::orderBy('designation')->get();

        return Inertia::render('Dashboard', [
            'vehicleConstructors' => $vehicleConstructors
        ]);
    }

    public function vehicleConstructor(VehicleConstructor $vehicleConstructor)
    {
        $vehicleModels = $vehicleConstructor->vehicleModels()->visible()->orderBy('designation')->get();

        return Inertia::render('Seo/VehicleConstructor', [
            'vehicleConstructor' => $vehicleConstructor,
            'vehicleModels' => $vehicleModels,
        ]);
    }

    public function vehicleModel(VehicleConstructor $vehicleConstructor, VehicleModel $vehicleModel)
    {
        $vehicleSpecifications = $vehicleModel->vehicleSpecifications()->visible()->orderBy('designation')->get();

        return Inertia::render('Seo/VehicleModel', [
            'vehicleConstructor' => $vehicleConstructor,
            'vehicleModel' => $vehicleModel,
            'vehicleSpecifications' => $vehicleSpecifications,
        ]);
    }

    public function vehicleSpecification(VehicleConstructor $vehicleConstructor, VehicleModel $vehicleModel, VehicleSpecification $vehicleSpecification)
    {
        $vehicles = $vehicleSpecification->vehicles()->get();

        return Inertia::render('Seo/VehicleSpecification', [
            'vehicleConstructor' => $vehicleConstructor,
            'vehicleModel' => $vehicleModel,
            'vehicleSpecification' => $vehicleSpecification,
            'vehicles' => $vehicles
        ]);
    }

    public function demo()
    {
        $vehicles = [];

        return Inertia::render('Demo', [
            'vehicles' => $vehicles,
        ]);
    }
}
