<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    protected $table = 'demande';

    protected $primaryKey = 'id';
    public $timestamps = true;



    protected $fillable = [
        'matricule_etudiant',
        'document_id',
        'statut',
        'remarque_admin',
        'admin_id',
    ];

    protected $casts = [
        
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'matricule_etudiant', 'matricule');
    }

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id', 'id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
}
