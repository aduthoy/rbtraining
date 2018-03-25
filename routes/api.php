<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'cors'], function () {
    Route::resource('generaltrainings','GeneralTrainingController');
    Route::resource('specifctrainings','SpecificTrainingController');
    Route::resource('pdms','PdmsController');
    Route::resource('areas','AreasController');
    /*Route::resource('subareas','SubAreasController');*/
    Route::resource('puestos','PuestosController');
    Route::get('areas/{area}/puestos','PuestosController@getPuestosByArea');
    Route::resource('personal','PersonalController');
    Route::get('personal/{area}/personal','PersonalController@getEmpleadosByArea');
    Route::get('personalpuesto/{pusto}/personal','PersonalController@getPersonalbyPuesto');
    Route::resource('trainingdate','TrainingDateController');
    Route::get('specifictrainings/{specifictraining_id}/trainingdate','TrainingDateController@getTrainingDatesBySpecificTrainingId');
    Route::get('generaltrainings/{generaltraining_id}/trainingdate','TrainingDateController@getTrainingDatesByGeneralTrainingId');
    Route::get('trainingdates/{TrainingdateId}/personal', 'TrainingDateController@getEmployeesByTrainingDate');
    Route::put('trainingdates/employees/{TrainingId}', 'TrainingDateController@addTrainingDatesEmployees');
    Route::put('trainingdates/employee/{TrainingId}', 'TrainingDateController@addTrainingDatesEmployee');
    Route::put('trainingdates/delemployees/{TrainingdateId}', 'TrainingDateController@detachTrainingDatesEmployees');
    Route::put('trainingdates/delemployee/{TrainingdateId}', 'TrainingDateController@detachTrainingDatesEmployee');
    Route::get('pdms/{pdmId}/trainingdate','TrainingDateController@getAllTrainingDatesByPdmId');
    Route::resource('carlos','CarlosController');
    Route::get('pdms/getAllPdmsByArea/{areaId}', 'PdmsController@getAllPdmsByArea');
});
