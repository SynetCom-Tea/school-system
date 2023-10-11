<?php

namespace Modules\GestionNote\Entities;

use App\Models\Apprenant;
use Illuminate\Database\Eloquent\Model;
use Modules\GestionNote\Entities\Evaluation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
