<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingDate_Personal extends Model
{
    protected $fillable = [
        'training_dates_id', 'personals_id', 'create_user_id', 'update_user_id'
    ];

    public function trainingdates(){
        return $this->belongsTo('App\TrainingDate', 'training_dates_id');
    }

    public function personals() {
        return $this->belongsTo('App\personal','personals_id')->orderBy('idEmpleado');
    }

}
