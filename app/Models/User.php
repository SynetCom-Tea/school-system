<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Enseignement\Entities\Enseignant;
use Modules\Scolarite\Entities\Tuteur;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'nom',
        'prenom',
        'type_user',
        'email',
        'user_id',
        'username',
        'etablissement_id',
        'tuteur_id',
        'etablissement_section_id',
        'enseignant_id',
        'apprenant_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function permission_roles(): HasMany
    {
        return $this->HasMany(PermissionRole::class);
    }
    public function etablissement(): BelongsTo
    {
        return $this->belongsTo(Etablissement::class);
    }
    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }
    public function tuteur(): BelongsTo
    {
        return $this->belongsTo(Tuteur::class);
    }
    public function apprenant(): BelongsTo
    {
        return $this->belongsTo(Apprenant::class);
    }
    public function section_etablissements(): BelongsToMany
    {
        return $this->belongsToMany(EtablissementSection::class);
    }
}
