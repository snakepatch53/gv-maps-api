<?php

namespace App\Http\Controllers;

use App\Models\Fiber;
use App\Models\FiberMarker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FiberMarkerController extends Controller
{

    public function index(Request $request)
    {
        $includes = [];
        if ($request->query('includeFiber')) $includes[] = 'fiber';

        // Restringimos el acceso dependiendo del rol del usuario
        $data = [];
        $data = FiberMarker::with($includes)->get();


        return response()->json([
            "success" => true,
            "message" => "Recursos encontrados",
            "data" => $data
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),  [
            'latitude' => 'required',
            'longitude' => 'required',
            'order' => 'numeric',
            'fiber_id' => 'required|exists:fibers,id',
        ], [
            'latitude.required' => 'El campo latitud es requerido',
            'longitude.required' => 'El campo longitud es requerido',
            'fiber_id.required' => 'El campo fiber_id es requerido',
            'order.numeric' => 'El campo order debe ser numérico',
            'fiber_id.exists' => 'El campo fiber_id no es válido',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        // select fibermarkers order by 'order'
        // $fiberMarkers = FiberMarker::where('fiber_id', $request->fiber_id)->get()->sortByDesc('order');

        // $order = $request->order;
        // if ($order == null) $order = $fiberMarkers->count() == 0 ? 1 : $fiberMarkers->first()->order + 1000;


        $fiberMarker = FiberMarker::create($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso creado",
            "errors" => null,
            "fiber_marker_created" => $fiberMarker,
            "data" => FiberMarker::where('fiber_id', $request->fiber_id)->get()
        ]);
    }

    public function show(FiberMarker $fiberMarker)
    {
        //
    }

    public function update(Request $request, FiberMarker $fiberMarker)
    {
        $validator = Validator::make($request->all(),  [
            'latitude' => 'required',
            'longitude' => 'required',
        ], [
            'latitude.required' => 'El campo latitud es requerido',
            'longitude.required' => 'El campo longitud es requerido'
        ]);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $fiberMarker->update(compact('latitude', 'longitude'));

        return response()->json([
            "success" => true,
            "message" => "Recurso actualizado",
            "errors" => null,
            "data" => FiberMarker::where('fiber_id', $fiberMarker->fiber_id)->get(),
            "token" => null
        ]);
    }

    public function destroy(FiberMarker $fiberMarker)
    {

        $fiberMarkers = FiberMarker::where('fiber_id', $fiberMarker->fiber_id)->get();
        if ($fiberMarkers->count() == 1) {
            $fiber = Fiber::find($fiberMarker->fiber_id);
            $fiber->delete();
            $fiberMarkers = [];
        }

        $fiberMarker->delete();

        $fiberMarkers = FiberMarker::where('fiber_id', $fiberMarker->fiber_id)->get();
        return response()->json([
            "success" => true,
            "message" => "Recurso eliminado",
            "errors" => null,
            "data" => $fiberMarkers
        ]);
    }
}
