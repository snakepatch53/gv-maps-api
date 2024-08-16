<?php

namespace App\Http\Controllers;

use App\Models\Map;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index(Request $request)
    {
        $includes = [];
        if ($request->query('includeEntity')) $includes[] = 'entity';
        if ($request->query('includeUser')) $includes[] = 'user';
        if ($request->query('includeFibers')) $includes[] = 'fibers';
        if ($request->query('includeMarkers')) $includes[] = 'markers';

        // Restringimos el acceso dependiendo del rol del usuario
        $data = [];
        $data = Map::with($includes)->get();


        return response()->json([
            "success" => true,
            "message" => "Recursos encontrados",
            "data" => $data
        ]);
    }

    public function store(Request $request)
    {
        //
    }


    public function show(Map $map)
    {
        //
    }

    public function update(Request $request, Map $map)
    {
        //
    }

    public function destroy(Map $map)
    {
        //
    }
}
