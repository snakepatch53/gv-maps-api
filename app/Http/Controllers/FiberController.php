<?php

namespace App\Http\Controllers;

use App\Models\Fiber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FiberController extends Controller
{
    public function index(Request $request)
    {

        $user = auth()->user();
        $entity = $user->entity;

        $includes = [];
        if ($request->query('includeMap')) $includes[] = 'map';
        if ($request->query('includeFiberMarkers')) $includes[] = 'fiberMarkers';

        // Restringimos el acceso dependiendo del rol del usuario
        $data = [];
        $data = Fiber::with($includes)->get();


        return response()->json([
            "success" => true,
            "message" => "Recursos encontrados",
            "data" => $data
        ]);
    }

    public function getByMapId(Request $request, $map_id)
    {

        $includes = [];
        if ($request->query('includeMap')) $includes[] = 'map';
        if ($request->query('includeFiberMarkers')) $includes[] = 'fiberMarkers';

        // Restringimos el acceso dependiendo del rol del usuario
        $data = [];
        $data = Fiber::with($includes)->where('map_id', $map_id)->get();


        return response()->json([
            "success" => true,
            "message" => "Recursos encontrados",
            "data" => $data
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),  [
            "type" => "required|in:" . implode(",", Fiber::$_TYPES),
            "map_id" => "required|exists:maps,id",
            "fiber_markers" => "required|array",
            "fiber_markers.*.latitude" => "required",
            "fiber_markers.*.longitude" => "required",
        ], [
            "type.required" => "El campo tipo es requerido",
            "type.in" => "El campo tipo no es válido",
            "map_id.required" => "El campo map_id es requerido",
            "map_id.exists" => "El campo map_id no es válido",
            "fiber_markers.required" => "El campo fiber_markers es requerido",
            "fiber_markers.array" => "El campo fiber_markers debe ser un arreglo",
            "fiber_markers.*.latitude.required" => "El campo latitude es requerido",
            "fiber_markers.*.longitude.required" => "El campo longitude es requerido",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        $fiber = Fiber::create($request->all());

        $fiber->fiberMarkers()->createMany($request->fiber_markers);

        return response()->json([
            "success" => true,
            "message" => "Recurso creado",
            "errors" => null,
            "fiber_created" => $fiber,
            "data" => Fiber::with(['map', 'fiberMarkers'])->where('map_id', $request->map_id)->get()
        ]);
    }

    public function show(Fiber $fiber)
    {
        //
    }

    public function update(Request $request, Fiber $fiber)
    {
        //
    }

    public function destroy(Fiber $fiber)
    {
        //
    }
}
