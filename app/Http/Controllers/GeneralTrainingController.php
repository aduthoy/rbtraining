<?php

namespace App\Http\Controllers;

use App\GeneralTraining;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GeneralTrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $curso = GeneralTraining::all();
        return Response($curso,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $curso = new GeneralTraining;

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
            return Response($curso,200);
        }
        return Response($curso,500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $curso = GeneralTraining::findOrFail($id);

        if ($curso) {
            return Response($curso,200);
        }
        return Response($id, 404);
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
        $curso = GeneralTraining::findOrFail($id);

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
            return Response($curso,200);
        }
        return Response($request,404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $curso = GeneralTraining::findOrFail($id);

        if ($curso->delete()) {
            return Response($curso,200);
        }
        return Response($id, 404);
    }
}
