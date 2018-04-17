<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * Created by PhpStorm.
 * User: aduhtoy
 * Date: 20/03/18
 * Time: 11:14
 *
 */

class TrainingDate extends Model {

    /**
     *
     */
    public function generalTraining() {
        return $this->belongsTo('App\GeneralTraining', 'general_training_id');
    }

    public function specificTraining() {
        return $this->belongsTo('App\SpecificTraining');
    }

    public function pdm() {
        return $this->belongsTo('App\pdms');
    }

    public function personals() {
        return $this->belongsToMany('App\personal','trainingdate_personal')
            ->withPivot('estatus', 'calificacion')
            ->withTimestamps();
    }
}