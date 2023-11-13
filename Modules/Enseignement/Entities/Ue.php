<?php

namespace Modules\Enseignement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ue extends Model
{
    use HasFactory;

    protected $fillable = ['code','libelle','etablissement_section_id'];
}
