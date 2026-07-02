<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


// Note: If you don't have a model yet, you can create one at
// `app/Models/ServiceVehicle.php` and adjust the namespace below.
use App\Models\ServiceVehicle;

class ServiceVehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $vehicles = ServiceVehicle::paginate(15);
        return view('service_vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('service_vehicles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateRequest($request);

        $vehicle = ServiceVehicle::create($data);

        return redirect()->route('service_vehicles.show', $vehicle)->with('success', 'Service vehicle created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceVehicle $serviceVehicle): View
    {
        return view('service_vehicles.show', ['vehicle' => $serviceVehicle]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceVehicle $serviceVehicle): View
    {
        return view('service_vehicles.edit', ['vehicle' => $serviceVehicle]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceVehicle $serviceVehicle): RedirectResponse
    {
        $data = $this->validateRequest($request, $serviceVehicle->id);

        $serviceVehicle->update($data);

        return redirect()->route('service_vehicles.show', $serviceVehicle)->with('success', 'Service vehicle updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceVehicle $serviceVehicle): RedirectResponse
    {
        $serviceVehicle->delete();
        return redirect()->route('service_vehicles.index')->with('success', 'Service vehicle deleted.');
    }

    /**
     * Validate request data for store/update.
     */
    protected function validateRequest(Request $request, $id = null): array
    {
        $rules = [
            'plate_number' => 'required|string|max:50|unique:service_vehicles,plate_number' . ($id ? ",$id" : ''),
            'model' => 'nullable|string|max:255',
            'owner_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ];

        return $request->validate($rules);
    }
}
