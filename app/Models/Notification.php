<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notification';

    protected $primaryKey = 'id';
    public $timestamps = true;


    const UPDATED_AT = null;

    protected $fillable = [
        'id_utilisateur',
        'matricule_etudiant',
        'message',
        'is_read',
        'role',
        'title',
        'type',
        'link',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'matricule_etudiant', 'matricule');
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'id_utilisateur', 'id');
    }
}
