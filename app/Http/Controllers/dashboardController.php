<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class dashboardController extends Controller
{

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getProximosaVencerByUserId($id) {
        $fecha = today();
        logger('Fecha del Sistema '.$fecha);
        //$fecha->endOfMonth();
        //$fecha->addDays(60);
        $fecha->endOfQuarter();
        logger('fecha maxima endofmonth '.$fecha);
        $datos = DB::table('Training_dates')
            ->join('trainingdate_personal','Training_dates.id','=','trainingdate_personal.training_date_id')
            ->where([
                ['trainingdate_personal.estatus','<>',1],
                ['trainingdate_personal.personal_id','=',$id],
                ['Training_dates.initial_date','<=',$fecha]
            ])
            //->where('initial_date BETWEEN sysdate() and date_add(sysdate(),INTERVAL 90 day) and personal.estatus = 0
            //and personal.personal_id = 1')
            ->select(DB::raw('count(general_training_id) AS general, count(specific_training_id) AS especifico, count(pdms_id) AS pdm'))
            ->get();
        /*$datos = DB::table('Training_dates')
            ->join('trainingdate_personal','Training_dates.id','=','trainingdate_personal.training_date_id')
            ->where(function ($query) {
                $query->where('training_dates.general_training_id', 'IS NOT', 'null')
                    ->where('trainingdate_personal.estatus', '<>', 1)
                    ->where('trainingdate_personal.personal_id', '=', $id)
                    ->where('Training_dates.initial_date', '<=', $fecha);
            })
            ->orwhere(function ($query1) {
                $query1->where('training_dates.pdms_id', 'IS NOT', 'null')
                    ->where('trainingdate_personal.estatus', '<>', 1)
                    ->where('trainingdate_personal.personal_id', '=', $id)
                    ->where('Training_dates.initial_date', '<=', $fecha);
            })
            //->where('initial_date BETWEEN sysdate() and date_add(sysdate(),INTERVAL 90 day) and personal.estatus = 0
            //and personal.personal_id = 1')
            ->select(DB::raw('count(general_training_id) AS general, count(specific_training_id) AS especifico, count(pdms_id) AS pdm'))
            ->get();*/
        return response($datos,200);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getProximosaVencerGeneralDetalleByUserId($id) {
        $fecha = today();
        //$fecha->endOfMonth();
        $fecha->addDays(30);
        logger('fecha final'.$fecha);
        $datos = DB::table('Training_dates')
            ->join('trainingdate_personal','Training_dates.id','=','trainingdate_personal.training_date_id')
            ->join('general_trainings','Training_dates.general_training_id', '=', 'general_trainings.id')
            ->where([
                ['trainingdate_personal.estatus','<>',1],
                ['trainingdate_personal.personal_id','=',$id],
                ['Training_dates.initial_date','<=',$fecha]
            ])
            ->orderBy('training_dates.initial_date','asc')
            ->get();
        return response($datos,200);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getProximosaVencerEspecificoDetalleByUserId($id) {
        $fecha = today();
        //$fecha->endOfMonth();
        $fecha->addDays(30);
        $datos = DB::table('Training_dates')
            ->join('trainingdate_personal','Training_dates.id','=','trainingdate_personal.training_date_id')
            ->join('specific_trainings','Training_dates.specific_training_id', '=', 'specific_trainings.id')
            ->where([
                ['trainingdate_personal.estatus','<>',1],
                ['trainingdate_personal.personal_id','=',$id],
                ['Training_dates.initial_date','<=',$fecha]
            ])
            //->where('initial_date BETWEEN sysdate() and date_add(sysdate(),INTERVAL 90 day) and personal.estatus = 0
            //and personal.personal_id = 1')
            //->select(DB::raw('*'))
            ->orderBy('training_dates.initial_date','asc')
            ->get();
        return response($datos,200);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getProximosaVencerPDMDetalleByUserId($id) {
        $fecha = today();
        $fecha->endOfQuarter();
        //$fecha->addDays(90);
        logger('Fin de Cuardo '.$fecha);
        $datos = DB::table('Training_dates')
            ->join('trainingdate_personal','Training_dates.id','=','trainingdate_personal.training_date_id')
            ->join('pdms','Training_dates.pdms_id', '=', 'pdms.id')
            ->join('areas','pdms.fk_areaPdm','=','areas.id')
            ->where([
                ['trainingdate_personal.estatus','<>',0],
                ['trainingdate_personal.personal_id','=',$id],
                ['Training_dates.initial_date','<=',$fecha]
            ])
            //->where('initial_date BETWEEN sysdate() and date_add(sysdate(),INTERVAL 90 day) and personal.estatus = 0
            //and personal.personal_id = 1')
            //->select(DB::raw('*'))
            ->orderBy('training_dates.initial_date','asc')
            ->get();
        return response($datos,200);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getProgramadosByUserId($id) {
        $datos = DB::table('Training_dates')
            ->join('trainingdate_personal','Training_dates.id','=','trainingdate_personal.training_date_id')
            ->where([
                ['trainingdate_personal.estatus','=',0],
                ['trainingdate_personal.personal_id','=',$id]
            ])
            ->select(DB::raw('count(general_training_id) AS general, count(specific_training_id) AS especifico, count(pdms_id) AS pdm'))
            ->get();
        return response($datos,200);
    }


    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getProgramadosGeneralDetalleByUserId($id) {
        $datos = DB::table('Training_dates')
            ->join('trainingdate_personal','Training_dates.id','=','trainingdate_personal.training_date_id')
            ->join('general_trainings','Training_dates.general_training_id', '=', 'general_trainings.id')
            ->where([
                ['trainingdate_personal.estatus','=',0],
                ['trainingdate_personal.personal_id','=',$id],
                //['Training_dates.initial_date','<=','date_add(sysdate(), INTERVAL 90 day)']
            ])
            ->orderBy('training_dates.initial_date','asc')
            //->where('initial_date BETWEEN sysdate() and date_add(sysdate(),INTERVAL 90 day) and personal.estatus = 0
            //and personal.personal_id = 1')
            //->select(DB::raw('*'))
            ->get();
        return response($datos,200);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getProgramadosEspecificoDetalleByUserId($id) {
        $datos = DB::table('Training_dates')
            ->join('trainingdate_personal','Training_dates.id','=','trainingdate_personal.training_date_id')
            ->join('specific_trainings','Training_dates.specific_training_id', '=', 'specific_trainings.id')
            ->where([
                ['trainingdate_personal.estatus','=',0],
                ['trainingdate_personal.personal_id','=',$id],
            ])
            ->orderBy('training_dates.initial_date','asc')
            ->get();
        return response($datos,200);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getProgramadosPDMDetalleByUserId($id) {
        $datos = DB::table('Training_dates')
            ->join('trainingdate_personal','Training_dates.id','=','trainingdate_personal.training_date_id')
            ->join('pdms','Training_dates.pdms_id', '=', 'pdms.id')
            ->join('areas','pdms.fk_areaPdm','=','areas.id')
            ->where([
                ['trainingdate_personal.estatus','=',0],
                ['trainingdate_personal.personal_id','=',$id],
                //['Training_dates.initial_date','<=','date_add(sysdate(), INTERVAL 90 day)']
            ])
            //->where('initial_date BETWEEN sysdate() and date_add(sysdate(),INTERVAL 90 day) and personal.estatus = 0
            //and personal.personal_id = 1')
            //->select(DB::raw('*'))
            ->orderBy('training_dates.initial_date','asc')
            ->get();
        return response($datos,200);
    }



    /*************************/


    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getCursadosByUserId($id) {
        $datos = DB::table('Training_dates')
            ->join('trainingdate_personal','Training_dates.id','=','trainingdate_personal.training_date_id')
            ->where([
                ['trainingdate_personal.estatus','=',1],
                ['trainingdate_personal.personal_id','=',$id]
//                ['Training_dates.initial_date','<=','date_add(sysdate(), INTERVAL 90 day)']
            ])
            //->where('initial_date BETWEEN sysdate() and date_add(sysdate(),INTERVAL 90 day) and personal.estatus = 0
            //and personal.personal_id = 1')
            ->select(DB::raw('count(general_training_id) AS general, count(specific_training_id) AS especifico, count(pdms_id) AS pdm'))
            ->get();
        return response($datos,200);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getCursadosGeneralDetalleByUserId($id) {
        $datos = DB::table('Training_dates')
            ->join('trainingdate_personal','Training_dates.id','=','trainingdate_personal.training_date_id')
            ->join('general_trainings','Training_dates.general_training_id', '=', 'general_trainings.id')
            ->where([
                ['trainingdate_personal.estatus','=',1],
                ['trainingdate_personal.personal_id','=',$id],
                //['Training_dates.initial_date','<=','date_add(sysdate(), INTERVAL 90 day)']
            ])
            ->orderBy('training_dates.initial_date','asc')
            //->where('initial_date BETWEEN sysdate() and date_add(sysdate(),INTERVAL 90 day) and personal.estatus = 0
            //and personal.personal_id = 1')
            //->select(DB::raw('*'))
            ->get();
        return response($datos,200);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getCursadosEspecificoDetalleByUserId($id) {
        $datos = DB::table('Training_dates')
            ->join('trainingdate_personal','Training_dates.id','=','trainingdate_personal.training_date_id')
            ->join('specific_trainings','Training_dates.specific_training_id', '=', 'specific_trainings.id')
            ->where([
                ['trainingdate_personal.estatus','=',1],
                ['trainingdate_personal.personal_id','=',$id],
                //['Training_dates.initial_date','<=','date_add(sysdate(), INTERVAL 90 day)']
            ])
            //->where('initial_date BETWEEN sysdate() and date_add(sysdate(),INTERVAL 90 day) and personal.estatus = 0
            //and personal.personal_id = 1')
            //->select(DB::raw('*'))
            ->orderBy('training_dates.initial_date','asc')
            ->get();
        return response($datos,200);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getCursadosPDMDetalleByUserId($id) {

        //return response(Hash::make('GMartinez'),200);


        $datos = DB::table('Training_dates')
            ->join('trainingdate_personal','Training_dates.id','=','trainingdate_personal.training_date_id')
            ->join('pdms','Training_dates.pdms_id', '=', 'pdms.id')
            ->join('areas','pdms.fk_areaPdm','=','areas.id')
            ->where([
                ['trainingdate_personal.estatus','=',1],
                ['trainingdate_personal.personal_id','=',$id],
                //['Training_dates.initial_date','<=','date_add(sysdate(), INTERVAL 90 day)']
            ])
            //->where('initial_date BETWEEN sysdate() and date_add(sysdate(),INTERVAL 90 day) and personal.estatus = 0
            //and personal.personal_id = 1')
            //->select(DB::raw('*'))
            ->orderBy('training_dates.initial_date','asc')
            ->get();
        return response($datos,200);
    }



}
