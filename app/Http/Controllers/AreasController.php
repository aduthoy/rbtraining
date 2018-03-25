<?php

namespace App\Http\Controllers;

use App\area;
use Illuminate\Http\Request;

class AreasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas = area::all();
        return response($areas,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $areas = new area();

        //$areas = $request->all();
        $areas->idAreas = $request->idAreas;
        $areas->nombreArea = $request->nombreArea;
        $areas->fk_user_create = 1; //$request->fk_user_create;
        $areas->fk_user_update = 1; //$request->fk_user_update;

        if ($areas->save()) {
            return response($areas,200);
        }
        return response($areas,500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $areas = area::findOrFale($id);

        if ($areas) {
            return response($areas,200);
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
        $areas = area::findOrFail($id);

        if ($areas) {
            $areas->idAreas = $request->idAreas;
            $areas->nombreArea = $request->nombreArea;
            $areas->fk_user_create = 1; //$request->fk_user_create;
            $areas->fk_user_update = 1; //$request->fk_user_update;

            if ($areas->save()) {
                return response($areas,200);
            }
            return response($id,500);
        }
        return response($areas,404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $areas = area::findOrFail($id);

        if ($areas->delete()) {
            return response($areas,200);
        }
        return response($id,404);
    }
}
