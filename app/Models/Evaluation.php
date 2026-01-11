<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $table = 'evaluation'; // explicit table name as DB uses singular

    protected $primaryKey = 'id';

    public $timestamps = false; // assuming this table may not have timestamps

    protected $fillable = [
        'matiere',
        'type_evaluation',
    ];
}
