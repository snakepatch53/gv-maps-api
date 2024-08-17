<?php

namespace App\Http\Controllers;

use App\Models\Fiber;
use App\Models\Marker;
use Illuminate\Http\Request;

class ComboController extends Controller
{
    public function getPublicMap($map_id)
    {

        $markers = Marker::where('map_id', $map_id)->get();
        $fibers = Fiber::with("fiberMarkers")->where('map_id', $map_id)->get();


        return response()->json([
            "success" => true,
            "message" => "Recursos encontrados",
            "data" => compact('markers', 'fibers')
        ]);
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
