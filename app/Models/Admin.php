<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';

    protected $primaryKey = 'id_admin';
    public $timestamps = false;

    protected $fillable = [
        'nom',
        'prenom',
        'id_utilisateur',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
