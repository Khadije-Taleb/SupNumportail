<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'document';

    protected $primaryKey = 'id_document';
    public $timestamps = false;

    protected $fillable = [
        'type_document',
        'description',
    ];

    public function demandes()
    {
        return $this->hasMany(Demande::class, 'id_document', 'id_document');
    }
}
