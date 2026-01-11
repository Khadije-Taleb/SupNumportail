<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $table = 'evaluation'; // explicit table name as DB uses singular

    protected $primaryKey = 'id';

    public $timestamps = false; // assuming this table may not have timestamps

    protected $fillable = [
        'nom_matiere',
        'type_evaluation',
    ];

    /**
     * Get all certificats for this evaluation
     */
    public function certificats()
    {
        return $this->hasMany(CertificatMedical::class, 'evaluation_id', 'id');
    }
}
