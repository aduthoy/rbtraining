<?php

namespace App\Http\Controllers;

use App\area;
use App\puesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function MongoDB\BSON\toJSON;

class PuestosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$area = area::findOrFail($id);
        $puestos = $area->puestos;
        if (!$area) {
            return response()->json(['mensaje' => 'Area no existe', 'codigo'=>404],404);
        }*/

        $puestos = puesto::all();
        return response($puestos, 200);

    }

    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getPuestosByArea($id)
    {
        /*$area = area::findOrFail($id);
        $puestos = $area->puestos;
        if (!$area) {
            return response()->json(['mensaje' => 'Area no existe', 'codigo'=>404],404);
        }*/

        $puestos = DB::table('puestos')->where('fk_area','=',$id)->get();
        return response($puestos, 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $puestos = new puesto();

        $puestos->idpuestos = $request->idpuestos;
        $puestos->nombrePuesto = $request->nombrePuesto;
        $puestos->fk_area= $request->fk_area;
        $puestos->fk_subArea = $request->fk_subArea;
        $puestos->fk_user_create= 1; //$request->fk_user_create;
        $puestos->fk_user_update = 1; //$request->fk_user_update;

        if ($puestos->save()) {
            response($puestos,200);
        }
        response($request,500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $puestos = puesto::findOrFail($id);
        if($puestos) {
            return response($puestos,200);
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
        $puestos = puesto::findOrFail($id);

        if ($puestos) {
            $puestos->idpuestos = $request->idpuestos;
            $puestos->nombrePuesto = $request->nombrePuesto;
            $puestos->fk_area = $request->fk_area;
            $puestos->fk_subArea = $request->fk_subArea;
            $puestos->fk_user_update = 1; //$request->fk_user_update;

            if ($puestos->save()) {
                response($puestos, 200);
            }
            response($request, 500);
        }
        response($request,404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $puestos = puesto::findOrFail($id);

        if ($puestos->delete()) {
            return response($puestos,200);
        }
        return response($id,404);
    }
}