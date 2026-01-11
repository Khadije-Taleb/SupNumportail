<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificatMedical extends Model
{
    protected $table = 'certificat_medical';

    protected $primaryKey = 'id';
    public $timestamps = true;


    const UPDATED_AT = null;

    protected $fillable = [
        'matricule_etudiant',
        'photo_certificat',
        'annee',
        'evaluation_id',
        'date_absence',
        'statut',
        'remarque_admin',
        'admin_id',
    ];

    protected $casts = [
        'date_absence' => 'date',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'matricule_etudiant', 'matricule');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    /**
     * Get the evaluation associated with this certificat
     */
    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class, 'evaluation_id', 'id');
    }
}
