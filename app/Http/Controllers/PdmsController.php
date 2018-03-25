<?php

namespace App\Http\Controllers;

use App\area;
use App\pdms;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PdmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pdms = pdms::all();
        return response($pdms, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pdms = new pdms();

        $pdms->cveActualpdm = $request->cveActualpdm;
        $pdms->cveAnteriorPmd = $request->cveAnteriorPmd;
        $pdms->tituloPdm = $request->tituloPdm;
        $pdms->fk_statusPmd = $request->fk_statusPmd;
        $pdms->fechaEfectivaPdm = date('Y-m-d',strtotime($request->fechaEfectivaPdm));
        $pdms->duenoDocPdm = $request->duenoDocPdm;
        $pdms->nombreProcesoPdm = $request->nombreProcesoPdm;
        $pdms->fk_areaPdm = $request->fk_areaPdm;
        $pdms->fk_estatusPdm = $request->fk_estatusPdm;
        $pdms->activo = $request->activo;
        $pdms->fk_user_create = 1; //$request->fk_user_create;
        $pdms->fk_user_update = 1; //$request->fk_user_update;

       if ($pdms->save()) {
           return response($pdms,200);
       }
       return response($pdms,500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pdms = pdms::findOrFail($id);

        if ($pdms) {
            return response($pdms,200);
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
        $pdms = pdms::findOrFail($id);

        if ($pdms) {
            $pdms->cveActualpdm = $request->cveActualpdm;
            $pdms->cveAnteriorPmd = $request->cveAnteriorPmd;
            $pdms->tituloPdm = $request->tituloPdm;
            $pdms->fk_statusPmd = $request->fk_statusPmd;
            $pdms->fechaEfectivaPdm = date('Y-m-d',strtotime($request->fechaEfectivaPdm));
            $pdms->duenoDocPdm = $request->duenoDocPdm;
            $pdms->nombreProcesoPdm = $request->nombreProcesoPdm;
            $pdms->fk_areaPdm = $request->fk_areaPdm;
            $pdms->fk_estatusPdm = $request->fk_estatusPdm;
            $pdms->activo = $request->activo;
            $pdms->fk_user_update = 1; //$request->fk_user_update;

            if ($pdms->save()) {
                return response($pdms, 200);
            }
            return response($request,500);
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
        $pdms = pdms::findOrFail($id);

        if ($pdms->delete()) {
            return response($pdms,200);
        }
        return response($id,404);
    }


    /**
     * Obtiene todos los Procedimietnos de una area determinada
     *
     * @param int $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getAllPdmsByArea($id)
    {
        $area = area::find($id);

        if ($area) {
            $pdms = $area->pdms;
            return response($pdms, 200);
        }
        return response()->json(['Error' => 'Area no existe'],404);
    }
}
