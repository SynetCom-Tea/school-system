<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Exceptions\RoleAlreadyExists;

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'guard_name', 'etablissement_section_id'];

      // OVERRIDE DE LA MÉTHODE DE CRÉATION DE SPATIE
    public static function create(array $attributes = [])
    {
        $attributes['guard_name'] = $attributes['guard_name'] ?? 'web';
        
        // VALIDATION PERSONNALISÉE - permet le même nom pour différents établissements
        if (static::where('name', $attributes['name'])
                 ->where('guard_name', $attributes['guard_name'])
                 ->where('etablissement_section_id', $attributes['etablissement_section_id'])
                 ->exists()) {
            throw RoleAlreadyExists::create($attributes['name'], $attributes['guard_name']);
        }

        return static::query()->create($attributes);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

    protected function getDefaultGuardName(): string
    {

        return 'web';
    }
    
    public function permission_roles(): HasMany
    {
        return $this->HasMany(PermissionRole::class);
    }

     // AJOUTEZ CETTE RELATION MANQUANTE
    
    public function etablissementSection(): BelongsTo
    {
        return $this->belongsTo(EtablissementSection::class, 'etablissement_section_id');
    }
}
