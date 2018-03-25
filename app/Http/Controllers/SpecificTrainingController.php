<?php

namespace App\Http\Controllers;

use App\SpecificTraining;
use Illuminate\Http\Request;

class SpecificTrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $curso = SpecificTraining::all();
        return response($curso,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $curso = new SpecificTraining();

        $curso->cve_curso = $request->cve_curso;
        $curso->nombre_curso = $request->nombre_curso;
        $curso->instructor_curso = $request->instructor_curso;
        $curso->tema_curso = $request->tema_curso;
        $curso->area_imparte_curso = $request->area_imparte_curso;
        $curso->duracionCurso = $request->duracionCurso;
        $curso->estatus_curso = $request->estatus_curso;
        $curso->fk_user_create = 1; //$request->user()->id;
        $curso->fk_user_update = 1; //$request->user()->id;

        if ($curso->save()) {
            return response($curso,200);
        }
        return response($curso,500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $curso = SpecificTraining::findOrFail($id);

        if ($curso) {
            return response($curso,200);
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
        $curso = SpecificTraining::findOrFail($id);

        if ($curso) {
            $curso->cve_curso = $request->cve_curso;
            $curso->nombre_curso = $request->nombre_curso;
            $curso->instructor_curso = $request->instructor_curso;
            $curso->tema_curso = $request->tema_curso;
            $curso->area_imparte_curso = $request->area_imparte_curso;
            $curso->duracionCurso = $request->duracionCurso;
            $curso->estatus_curso = $request->estatus_curso;
            $curso->fk_user_update = 1; //$request->user()->id;
            $curso->save();
            return response($curso,200);
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
        $curso = SpecificTraining::findOrFail($id);

        if ($curso->delete()) {
            return response($curso,200);
        }
        return response($id, 404);    }
}
