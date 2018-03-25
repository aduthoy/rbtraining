<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecificTraining extends Model
{
    public function training_dates ()
    {
        return $this->hasMany('App\TrainingDate')->orderBy('initial_date');
    }
}
