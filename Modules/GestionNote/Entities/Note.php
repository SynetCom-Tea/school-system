<?php

namespace Modules\GestionNote\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Note extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['date', 'note', 'evaluation_id', 'apprenant_id'];


    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }
    public function apprenant()
    {
        return $this->belongsTo(Apprenant::class);
    }
}
