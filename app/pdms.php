<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pdms extends Model
{

    public function training_dates() {
        return $this->hasMany('App\TrainingDate');
    }

    public function area() {
        return $this->belongsTo('App\area','fk_areaPdm');
    }
}
