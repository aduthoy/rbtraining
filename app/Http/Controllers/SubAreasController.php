<?php

namespace App\Http\Controllers;

use App\subarea;
use Illuminate\Http\Request;

class SubAreasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subareas = subarea::all();
        return response($subareas,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subareas = new subarea();

        $subareas->idSubareas = $request->idSubareas;
        $subareas->nombreSubarea = $request->nombreSubarea;
        $subareas->fk_Area = $request->fk_Area;
        $subareas->fk_user_create = 1; //$request->fk_user_create;
        $subareas->fk_user_update = 1; //$request->fk_user_update;

        if ($subareas->save()) {
            return response($subareas,200);
        }
        return response($subareas,500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subareas = subarea::findOrFale($id);

        if ($subareas) {
            return response($subareas,200);
        }
        return response($id,404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $subareas = subarea::findOrFail($id);

        if ($subareas) {
            $subareas->idSubareas = $request->idSubareas;
            $subareas->nombreSubarea = $request->nombreSubarea;
            $subareas->fk_Area = $request->fk_Area;
            $subareas->fk_user_update = 1; //$request->fk_user_update;

            if ($subareas->save()) {
                return response($subareas,200);
            }
            return response($id,500);
        }
        return response($subareas,404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subareas = subarea::findOrFale($id);

        if ($subareas->delete()) {
            return response($subareas,200);
        }
        return response($id,404);
    }
}
