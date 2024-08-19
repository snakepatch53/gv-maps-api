<?php

namespace App\Http\Controllers;

use App\Models\Marker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MarkerController extends Controller
{
    public function index(Request $request)
    {
        $includes = [];
        if ($request->query('includeMap')) $includes[] = 'map';

        // Restringimos el acceso dependiendo del rol del usuario
        $data = [];
        $data = Marker::with($includes)->get();


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

        // Restringimos el acceso dependiendo del rol del usuario
        $data = [];
        $data = Marker::with($includes)->where('map_id', $map_id)->get();


        return response()->json([
            "success" => true,
            "message" => "Recursos encontrados",
            "data" => $data
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),  [
            "latitude" => "required",
            "longitude" => "required",
            "type" => "required|in:" . implode(",", Marker::$_TYPES),
            "map_id" => "required|exists:maps,id"
        ], [
            "latitude.required" => "El campo latitud es requerido",
            "longitude.required" => "El campo longitud es requerido",
            "type.required" => "El campo tipo es requerido",
            "type.in" => "El campo tipo no es válido",
            "map_id.required" => "El campo map_id es requerido",
            "map_id.exists" => "El campo map_id no es válido"
        ]);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        Marker::create($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso creado",
            "errors" => null,
            "data" => Marker::with('map')->where('map_id', $request->map_id)->get()
        ]);
    }

    public function show(Marker $marker)
    {
        //
    }

    public function move(Request $request, $id)
    {
        $marker = Marker::find($id);
        if (!$marker) {
            return response()->json([
                "success" => false,
                "message" => "Recurso no encontrado",
                "data" => null
            ]);
        }

        $validator = Validator::make($request->all(),  [
            "latitude" => "required",
            "longitude" => "required",
        ], [
            "latitude.required" => "El campo latitud es requerido",
            "longitude.required" => "El campo longitud es requerido",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        $lat = $request->latitude;
        $lng = $request->longitude;


        $marker->update([
            "latitude" => $lat,
            "longitude" => $lng
        ]);

        return response()->json([
            "success" => true,
            "message" => "Recurso actualizado",
            "errors" => null,
            "data" => Marker::with('map')->where('map_id', $marker->map_id)->get(),
            "token" => null
        ]);
    }

    public function update(Request $request, Marker $marker)
    {
        $validator = Validator::make($request->all(),  [
            'name' => "required",
            "latitude" => "required",
            "longitude" => "required",
            "type" => "in:" . implode(",", Marker::$_TYPES),
            'reserve_meters' => 'required_if:type,' . Marker::$_TYPES[2], // reserve type
            'nap_buffer' => 'required_if:type,' . Marker::$_TYPES[4] . ',' . Marker::$_TYPES[5], // nap type
            'nap_thread' => 'required_if:type,' . Marker::$_TYPES[4] . ',' . Marker::$_TYPES[5], // nap type
            'nap_ports' => 'required_if:type,' . Marker::$_TYPES[4] . ',' . Marker::$_TYPES[5], // nap type
            "map_id" => "prohibited"
        ], [
            "name.required" => "El campo nombre es requerido",
            "latitude.required" => "El campo latitud es requerido",
            "longitude.required" => "El campo longitud es requerido",
            "type.in" => "El campo tipo no es válido",
            'reserve_meters.required_if' => "El campo reserve_meters es requerido",
            'nap_buffer.required_if' => "El campo nap_buffer es requerido",
            'nap_thread.required_if' => "El campo nap_thread es requerido",
            'nap_ports.required_if' => "El campo nap_ports es requerido",
            "map_id.prohibited" => "No puedes enviar el campo map_id"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        $marker->update($request->all());

        return response()->json([
            "success" => true,
            "message" => "Recurso actualizado",
            "errors" => null,
            "data" => Marker::with('map')->where('map_id', $marker->map_id)->get(),
            "token" => null
        ]);
    }

    public function destroy(Marker $marker)
    {
        $marker->delete();

        return response()->json([
            "success" => true,
            "message" => "Recurso eliminado",
            "errors" => null,
            "data" => Marker::with('map')->where('map_id', $marker->map_id)->get()
        ]);
    }
}
