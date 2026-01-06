<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificatMedical extends Model
{
    protected $table = 'certificat_medical';

    protected $primaryKey = 'id_certificat';
    public $timestamps = false;

    protected $fillable = [
        'etudiant_matricule',
        'annee',
        'type_evaluation',
        'matiere',
        'date_evaluation',
        'fichier',
        'statut',
        'remarque_admin',
        'date_upload',
        'admin_id',
    ];

    protected $casts = [
        'date_evaluation' => 'datetime',
        'date_upload' => 'datetime',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_matricule', 'matricule');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id_admin');
    }
}
