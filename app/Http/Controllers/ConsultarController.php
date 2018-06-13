<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ConsultarController extends Controller
{
    public function getGenearlTrainingQuery(Request $request) {

        logger('*****************************************');
        logger('******** getGenearlTrainingQuery ********');
        logger('*****************************************');
        logger('');
        logger('Info recibida ', $request->toArray());
        logger('');
        $area = $request->area;
        $curso = $request->curso;
        $fecha_ini = $request->fecha_ini;
        $fecha_fin = $request->fecha_fin;
        $puesto = $request->puesto;
        $tipo_Curso = $request->tipo_Curso;
        $empleados = $request->empleados;
        logger( 'area: '. $area);
        logger( 'curso: '. $curso);
        logger( 'fecha_ini: '.$fecha_ini);
        logger( 'fecha_fin: '.$fecha_fin);
        logger( 'puesto: '.$puesto);
        logger( 'Tipo_Curso: '.$tipo_Curso);
        //logger( 'empleados: '.$request->empleados);


        $where_curso = '';
        $where_area = '';
        $where_puesto = '';
        $where_empleados = '';
        $where_fechas='';
        $where_fecha_fin='';

        if ($curso != 0) {
            $where_curso = 'a.id = ' . $curso;
        } else {
            $where_curso = 'a.id like \'%\'';
        }
        if ($area != 0) {
            $where_area = 'a2.id = ' . $area;
        } else {
            $where_area = 'a2.id like \'%\'';
        }
        if ($puesto != 0) {
            $where_puesto = 'p2.id = ' . $puesto;
        } else {
            $where_puesto = 'p2.id like \'%\'';
        }
        if ($empleados!= 0) {
            if (count($empleados) > 0) {
                $text = '';
                for ($i = 0; $i < count($empleados) - 1; $i++) {
                    $text = $text . $empleados[$i] . ',';
                }
                $where_empleados = 'p.id in (' . $text . $empleados[$i] . ')';
            } else {
                $where_empleados = 'p.id like \'%\'';
            }
        } else {
            $where_empleados = 'p.id like \'%\'';
        }
        if ($fecha_ini != null) {
            $where_fechas = 'date2.initial_date >= \'' . date("Y-m-d",strtotime($fecha_ini)).'\'';
            if ($fecha_fin != null) {
                $where_fechas = $where_fechas.' and date2.initial_date <= \'' . date('Y-m-d',strtotime($fecha_fin)).'\'';
            }
        } else if ($fecha_fin != null) {
            $where_fechas = 'date2.initial_date <= \'' . date("Y-m-d",strtotime($fecha_fin)).'\'';
        }

        $where = $where_curso . ' and ' . $where_area . ' and ' . $where_puesto . ' and ' . $where_empleados;

        if ($where_fechas != '') {
            $where = $where.' and '.$where_fechas;
        }
        if ($tipo_Curso == '1') {
            logger('BUSQUEDA DE CURSOS GENERALES');
            $query = 'select a.nombre_curso, date2.initial_date, date2.location,' .
                ' personal.estatus, personal.calificacion, p.nombre, a2.nombreArea, p2.nombrePuesto, personal.updated_at' .
                ' from general_trainings AS  a' .
                ' INNER JOIN training_dates date2 ON a.id = date2.general_training_id' .
                ' INNER JOIN trainingdate_personal personal ON date2.id = personal.training_date_id' .
                ' INNER JOIN personals p ON personal.personal_id = p.id' .
                ' INNER JOIN areas a2 ON p.fk_Area = a2.id' .
                ' INNER JOIN puestos p2 ON p.fk_Puesto = p2.id' .
                ' WHERE ' . $where .
                ' order by p.nombre asc, date2.initial_date asc';
        }
        else {
            logger('BUSQUEDA DE CURSOS ESPECIFICOS');
            $query = 'select a.nombre_curso, date2.initial_date, date2.location,' .
                ' personal.estatus, personal.calificacion, p.nombre, a2.nombreArea, p2.nombrePuesto, personal.updated_at' .
                ' from specific_trainings AS  a' .
                ' INNER JOIN training_dates date2 ON a.id = date2.specific_training_id' .
                ' INNER JOIN trainingdate_personal personal ON date2.id = personal.training_date_id' .
                ' INNER JOIN personals p ON personal.personal_id = p.id' .
                ' INNER JOIN areas a2 ON p.fk_Area = a2.id' .
                ' INNER JOIN puestos p2 ON p.fk_Puesto = p2.id' .
                ' WHERE ' . $where .
                ' order by p.nombre asc, date2.initial_date asc';
        }
        logger( 'QUERY: '.$query);
        logger( 'Curso: '.$where_curso);
        logger( 'area: '.$where_area);
        logger( 'puesto: '.$where_puesto);
        logger( 'empleados: '.$where_empleados);
        logger( 'fecha_fechas: '.$where_fechas);
        logger( 'where: '.$where);

        $datos = DB::select($query);

        return response($datos,200);
    }
}
