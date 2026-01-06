<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $table = 'etudiant';

    protected $primaryKey = 'matricule';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'filiere',
        'annee',
        'id_utilisateur',
    ];

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'id_utilisateur', 'id_utilisateur');
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class, 'matricule', 'matricule');
    }

    public function certificatMedicals()
    {
        return $this->hasMany(CertificatMedical::class, 'etudiant_matricule', 'matricule');
    }
}
