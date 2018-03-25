<?php

namespace App\Http\Controllers;

use App\personal;
use App\puesto;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class carlosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fecha = today()->addMonth(6);

        $trim = $this->trimestre($fecha);

        $año = $fecha->year;
        //$fecha = date('Y-m-d',strtotime($request->fechaEfectivaPdm));
        return response($fecha,200);
    }



    /**
     * Determina el trimestre de una fecha dada.
     *
     * @param $datetime
     * @return float|int
     */
    public function trimestre($datetime)
    {
        $mes = date('m' ,strtotime($datetime));
        /*$mes = is_null($mes) ? date('m') : $mes;
        $trim = floor(($mes-1) / 3) + 1;*/
        if ($mes >=1 && $mes <=3) {
            return 1;
        } else if ($mes>=4 && $mes<=6) {
            return 2;
        } else if ($mes>=7 && $mes<=9) {
            return 3;
        }
        return 4;
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fecha = new Carbon($request->fecha, null);
        $mes = $fecha->month;
        $q = $fecha->quarter;


        return response($q);

    }

    /**
     * Display the specified resource.
     *
     * @param  Request  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response($id,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
