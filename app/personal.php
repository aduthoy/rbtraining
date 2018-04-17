<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class personal extends Model
{
    //

    public function area() {
        return $this->belongsTo('App\area','fk_Area');
    }

    public function puesto() {
        return $this->belongsTo('App\puesto', 'fk_Puesto');
    }

    public function TrainingDates() {
        return $this->belongsToMany('App\TrainingDate','trainingdate_personal')
            ->withPivot('estatus', 'calificacion')
            ->withTimestamps();
    }
}
