<?php

namespace Modules\Enseignement\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Filliere extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'code','cycle_id'];


    public function etablissements(): BelongsToMany
    {
        return $this->belongsToMany(Etablissement::class);
    }
   public function cycle(): BelongsTo
    {
        return $this->belongsTo(Cycle::class);
    }

    public function facultes(): BelongsToMany
    {
        return $this->belongsToMany(Faculte::class);
    }
}
