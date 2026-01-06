<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    protected $table = 'demande';

    protected $primaryKey = 'id_demande';
    public $timestamps = false;

    protected $fillable = [
        'date_demande',
        'statut',
        'remarque_admin',
        'matricule',
        'id_document',
        'id_admin',
    ];

    protected $casts = [
        'date_demande' => 'datetime',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'matricule', 'matricule');
    }

    public function document()
    {
        return $this->belongsTo(Document::class, 'id_document', 'id_document');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }
}
