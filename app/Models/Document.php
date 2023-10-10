<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['apprenant_id','type_document_id','file'];

    public function apprenant()
    {
        return $this->belongsTo(Apprenant::class);
    }

    public function type_document()
    {
        return $this->belongsTo(TypeDocument::class);
    }
}
