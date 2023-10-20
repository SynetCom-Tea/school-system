<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['code','libelle','section_id'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
