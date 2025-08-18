<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('menu_items')->get();
        return response()->json($services);
    }
    public function update(Request $request, Service $service)
    {
        $service->available = $request->input('available');
        $service->save();

        return response()->json([
            'success' => true,
            'service' => $service
        ]);
    }
}
