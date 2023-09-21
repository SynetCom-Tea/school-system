<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermissionRole extends Model
{
    use HasFactory;
    protected $fillable = ['permission_id', 'role_id','user_id'];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function permission(): BelongsTo
    {
        return $this->BelongsTo(Permission::class);
    }
}