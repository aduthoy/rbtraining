<?php

namespace App\Http\Controllers;

use App\area;
use App\personal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personal = DB::table('personals')
            ->join('areas','personals.fk_area','=','areas.id')
            ->join('puestos','personals.fk_puesto','=','puestos.id')
            ->select('personals.*','areas.nombreArea','puestos.nombrePuesto')
            ->get();
        return response($personal,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $personal = new personal();

        $personal->idEmpleado = $request->idEmpleado;
        $personal->nombreEmpleado = $request->nombreEmpleado;
        $personal->apellidoPaterno = $request->apellidoPaterno;
        $personal->apellidoMaterno = $request->apellidoMaterno;
        $personal->fk_Area = $request->fk_Area;
        $personal->fk_Puesto = $request->fk_Puesto;
        $personal->activo = $request->activo;
        $personal->user_create = 1; //$request->user_create;
        $personal->user_update = 1; //$request->user_update;

        if ($personal->save()) {
            return response($personal,200);
        }
        return response($request,500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $personal = personal::findOrFail($id);
        //$area = $personal->area;
        if ($personal) {
            return response($personal,200);
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
        //$personal = new personal();
        $personal = personal::findOrFail($id);
        if ($personal) {
            $personal->idEmpleado = $request->idEmpleado;
            $personal->nombreEmpleado = $request->nombreEmpleado;
            $personal->apellidoPaterno = $request->apellidoPaterno;
            $personal->apellidoMaterno = $request->apellidoMaterno;
            $personal->fk_Area = $request->fk_Area;
            $personal->fk_Puesto = $request->fk_Puesto;
            $personal->activo = $request->activo;
            $personal->user_update = 1; //$request->user_update;

            if ($personal->save()) {
                return response($personal, 200);
            }
            return response($request, 500);
        }
        return response($request,404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $personal = personal::findOrFail($id);
        if ($personal->delete()) {
            return response($personal,200);
        }
        return response($id,404);
    }

    /**
     * Regresa todos los empleados que de un pueto
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function getEmpladosByPuesto($id) {

        return response('Emplados de un puesto determinado por '+ $id );
    }

    /**
     * Obtiene todos los empleados de una area determinada
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function getEmpleadosByArea($id) {

        $personal = DB::table('personals')
            ->join('areas','personals.fk_area','=','areas.id')
            ->join('puestos','personals.fk_puesto','=','puestos.id')
            ->select('personals.*','areas.nombreArea','puestos.nombrePuesto')
            ->where('personals.fk_area','=',$id)
            ->get();
        return response($personal,200);
    }


    /**
     * Obtiene todos los empeleados de un puesto determinado
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function getPersonalbyPuesto($id) {

        $personal = DB::table('personals')
            ->join('areas','personals.fk_area','=','areas.id')
            ->join('puestos','personals.fk_puesto','=','puestos.id')
            ->select('personals.*','areas.nombreArea','puestos.nombrePuesto')
            ->where('personals.fk_puesto','=',$id)
            ->get();
        return response($personal,200);
    }

}
