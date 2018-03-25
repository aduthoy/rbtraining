<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class puesto extends Model
{
    protected $fillable = [
        'idpuestos', 'nombrePuesto', 'fk_area', 'fk_subArea', 'fk_user_create', 'fk_user_update'
    ];

    public function areas(){
        return $this->belongsTo('App\area','fk_area');
    }

    public function personals(){
        return $this->hasMany('App\personal','fk_puesto');
    }
}
