<?php

namespace App\Http\Controllers;

use App\GeneralTraining;
use App\pdms;
use App\SpecificTraining;
use App\TrainingDate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TrainingDateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trainingdate = TrainingDate::all();
        return response($trainingdate,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fecha = new Carbon($request->initial_date,null);
        $trainingdate = TrainingDate::find($request->id);
        if (!$trainingdate) {
            $trainingdate = new TrainingDate();
        }
        $trainingdate->general_training_id = $request->general_training_id;
        $trainingdate->specific_training_id = $request->specific_training_id;
        $trainingdate->pdms_id = $request->pdms_id;
        $trainingdate->initial_date = date('Y-m-d', strtotime($request->initial_date));
        $trainingdate->end_date = null;
        $trainingdate->quarter = $fecha->quarter;
        $trainingdate->year = $fecha->year;
        $trainingdate->location = $request->location;
        $trainingdate->estatus = $request->estatus;
        $trainingdate->create_user_id = 1; //$request->create_user_id;
        $trainingdate->update_user_id = 1; //$request->update_user_id;

        if ($trainingdate->save()) {
            return response($request,200);
        }
        return response('Error no se pudo insertar la fecha del curso',500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $trainingdate = TrainingDate::findOrFail($id);
        if ($trainingdate) {
            return response($trainingdate,200);
        }
        return response()->json(['Mensaje' => 'Registro '.$id.' no encontrado']);
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
        $trainingdate = TrainingDate::findOrFail($id);

        if ($trainingdate) {
            $fecha = new Carbon($request->initial_date,null);
            $trainingdate->general_training_id = $request->general_training_id;
            $trainingdate->specific_training_id = $request->spcific_training_id;
            $trainingdate->pdm_id = $request->pdm_id;
            $trainingdate->initial_date = date('Y-m-d', strtotime($request->initial_date));
            $trainingdate->end_date = null;
            $trainingdate->quarter = $fecha->quarter;
            $trainingdate->year = $fecha->year;
            $trainingdate->location = $request->location;
            $trainingdate->create_user_id = 1; //$request->create_user_id;
            $trainingdate->update_user_id = 1; //$request->update_user_id;

            if ($trainingdate->save()) {
                return response($request, 200);
            }
            return response($request,500);
        }
        return response($id,404);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $trainingdate = TrainingDate::findOrFail($id);

        if ($trainingdate) {
            if ($trainingdate->delete()) {
                return response($id,200);
            }
            return response($id,500);
        }
        return response($id,404);
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

    public function getTrainingDatesByGeneralTrainingId($generalTrainingId) {
        $generalTraining = GeneralTraining::findOrFail($generalTrainingId);
        $trainingDates = $generalTraining->training_dates;
        if ($trainingDates) {
            return response($trainingDates,200);
        }
        else response($generalTrainingId,404);
    }

    /*
     * Regresa colección de empledos asociados con la fecha del curso.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @param $id
     */
    public function getEmployeesByTrainingDate($id) {

        $trainigdate = TrainingDate::find($id);
        if ($trainigdate) {
            foreach ($trainigdate->personals as $emp) {
                $emp->area;
                $emp->puesto;
            }
            return response($trainigdate->personals,200);
        }
        return response($id,404);

    }

    /**
     *
     * Recibe un arreglo de empleados y los agrega a la lista de empleados al curso
     *
     * @param \Illuminate\Http\Request $employees
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function addTrainingDatesEmployees(Request $employees, $id)
    {

        $ids = array();
        $i = 0;

        $trainingdates = TrainingDate::find($id);
        if($trainingdates) {
            $size = count($employees->toArray());
            for ($i = 0; $i < $size; $i++) {
                $ids[$i] = $employees[$i]['id'];
            }
            $trainingdates->personals()->syncWithoutDetaching($ids);
            return response($employees, 200);
        }
        return response()->json(['Error' => 'Fecha de curso no localizada'],404);
    }

    /**
     *
     * Inserta un Empleado en la relación con cursos
     *
     * @param Request $employee
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function AddTrainingDatesEmployee(Request $employee, $id) {

        $trainingdates = TrainingDate::find($id);
        if($trainingdates) {
            $trainingdates->personals()->syncWithoutDetaching(intval($employee->id));
            return response($employee, 200);
        }
        return response()->json(['Error' => 'Fecha de curso no localizada'],404);
    }

    /**
     *
     * Recibe un arreglo de empelados y los quita de la lista de emplados al curso
     *
     * @param Request $employees
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function detachTrainingDatesEmployees(Request $employees, $id) {

        $ids = array();
        $i = 0;

        $trainingdates = TrainingDate::find($id);
        if($trainingdates) {
            $size = count($employees->toArray());
            for ($i = 0; $i < $size; $i++) {
                $ids[$i] = $employees[$i]['id'];
            }
            $trainingdates->personals()->detach($ids);
            return response($employees, 200);
        }
        return response()->json(['Error' => 'Fecha de curso no localizada'],404);
    }

    /**
     *
     * Recibe un empelados y los quita de la lista de emplados al curso
     *
     * @param Request $employees
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function detachTrainingDatesEmployee(Request $employee, $id) {

        $trainingdates = TrainingDate::find($id);
        if($trainingdates) {
            $trainingdates->personals()->detach(intval($employee->id));
            return response($employee, 200);
        }
        return response()->json(['Error' => 'Fecha de curso no localizada'],404);
    }

    /**
     *
     * Obtiene el calenario de cursos especificos del curso indicado.
     *
     * @param $specificTrainingId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getTrainingDatesBySpecificTrainingId($specificTrainingId) {

        $specificTraining = SpecificTraining::findOrFail($specificTrainingId);
        $trainingDates = $specificTraining->training_dates;
        if ($trainingDates) {
            return response($trainingDates,200);
        }
        else response($specificTrainingId,404);
    }

    /**
     *
     * Obtiene las fechas programadas para es pdm inidcado
     *
     * @param int $pdmId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getAllTrainingDatesByPdmId($pdmId) {
        $pdm = pdms::findOrFail($pdmId);
        $trainingDates = $pdm->training_dates;
        if ($trainingDates) {
            return response($trainingDates,200);
        }
        else {
            return response($pdmId,404);
        }
    }
}
