<?php

namespace Modules\Emploi\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emploi extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['code', 'date_debut', 'date_fin'];
    
    protected static function newFactory()
    {
        return \Modules\Emploi\Database\factories\EmploiFactory::new();
    }

    public function classeAnnee(): BelongsTo
    {
        return $this->belongsTo(ClasseAnnee::class);
    }

    public function seances(): HasMany
    {
        return $this->hasMany(Seance::class);
    }
}
