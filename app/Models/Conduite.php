<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conduite extends Model
{
    use HasFactory;

    protected $fillable = [
        'apprenant_id',
        'classe_annee_id',
        'periode_id',
        'note',
        'user_id',
    ];

    public function apprenant(): BelongsTo
    {
        return $this->belongsTo(Apprenant::class);
    }

    public function classe_annee(): BelongsTo
    {
        return $this->belongsTo(ClasseAnnee::class);
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(\Modules\GestionNote\Entities\Periode::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
