<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notification';

    protected $primaryKey = 'id_notification';
    public $timestamps = false;

    protected $fillable = [
        'message',
        'date_notification',
        'lu',
        'id_utilisateur',
    ];

    protected $casts = [
        'lu' => 'boolean',
        'date_notification' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_utilisateur', 'id_utilisateur');
    }
}
