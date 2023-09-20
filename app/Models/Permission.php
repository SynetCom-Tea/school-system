<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Permission extends \Spatie\Permission\Models\Permission
{
    use HasFactory;

    protected $fillable = ['name', 'guard_name', 'description'];

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
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
