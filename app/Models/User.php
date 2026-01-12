<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    protected $table = 'utilisateur';

    protected $primaryKey = 'id';

    public $timestamps = false; // The table uses date_creation

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'password',
        'role',
        'premiere_connexion',
    ];

    /**
     * Override to use mot_de_passe for authentication.
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
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

    public function getInitialsAttribute()
    {
        if ($this->role === 'etudiant' && $this->etudiant) {
            return strtoupper(substr($this->etudiant->prenom, 0, 1) . substr($this->etudiant->nom, 0, 1));
        }
        if ($this->role === 'admin' && $this->admin) {
            return strtoupper(substr($this->admin->prenom, 0, 1) . substr($this->admin->nom, 0, 1));
        }
        return strtoupper(substr($this->email, 0, 2));
    }

    // Relationships
    public function etudiant()
    {
        return $this->hasOne(Etudiant::class, 'utilisateur_id', 'id');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'utilisateur_id', 'id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'id_utilisateur', 'id');
    }

    public function getAllNotifications()
    {
        return $this->notifications();
    }
}
