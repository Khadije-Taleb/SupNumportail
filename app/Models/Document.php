<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'document';

    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nom_document',
        'description',
    ];

    public function demandes()
    {
        return $this->hasMany(Demande::class, 'document_id', 'id');
    }
}
