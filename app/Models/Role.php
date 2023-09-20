<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'guard_name'];

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
}
