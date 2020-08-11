<?php

namespace App\Modules\Serm\Models;

use Illuminate\Database\Eloquent\Model;

class SermProject extends Model {

    protected $table = 'serm_project';
    protected $fillable = ['name', 'url', 'user'];

}
