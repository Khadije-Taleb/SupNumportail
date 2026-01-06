<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    protected $table = 'utilisateur';
    
    protected $primaryKey = 'id_utilisateur';

    public $timestamps = false; // The table uses date_creation

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'mot_de_passe',
        'role',
        'actif',
        'premiere_connexion',
    ];

    /**
     * Override to use mot_de_passe for authentication.
     */
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'mot_de_passe',
    ];

    /**
     * Disable remember token functionality as it doesn't exist in the database.
     */
    public function getRememberToken()
    {
        return null;
    }

    public function setRememberToken($value)
    {
        // Do nothing
    }

    public function getRememberTokenName()
    {
        return null; // Return null to indicate no remember token column
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getFullNameAttribute()
    {
        if ($this->role === 'etudiant' && $this->etudiant) {
            return $this->etudiant->prenom . ' ' . $this->etudiant->nom;
        }
        if ($this->role === 'admin' && $this->admin) {
            return $this->admin->prenom . ' ' . $this->admin->nom;
        }
        return $this->email;
    }

    // Relationships
    public function etudiant()
    {
        return $this->hasOne(Etudiant::class, 'id_utilisateur', 'id_utilisateur');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'id_utilisateur', 'id_utilisateur');
    }

    public function getAllNotifications()
    {
        return $this->hasMany(Notification::class, 'id_utilisateur', 'id_utilisateur');
    }
}
