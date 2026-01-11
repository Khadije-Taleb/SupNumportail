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
        'email',
        'utilisateur_id',
    ];

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateur_id', 'id');
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class, 'matricule_etudiant', 'matricule');
    }

    public function certificatMedicals()
    {
        return $this->hasMany(CertificatMedical::class, 'matricule_etudiant', 'matricule');
    }
}
