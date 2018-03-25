<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class area extends Model
{
    protected $fillable = [
        'idAreas', 'nombreArea', 'fk_user_create', 'fk_user_update'
    ];

    public function puestos(){
        return $this->hasMany('App\puesto', 'fk_area');
    }

    public function empleados() {
        return $this->hasMany('App\personal','fk_area');
    }

    public function pdms() {
        return $this->hasMany('App\pdms','fk_areaPdm')->orderBy('cveActualpdm','asc');
    }

}
