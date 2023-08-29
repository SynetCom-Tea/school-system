<?php

namespace Modules\Enseignement\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cycle extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['id','name'];

    public function cursus_post_bacs(): HasMany
    {
        return $this->hasMany(CursusPostBac::class);
    }
    
}
