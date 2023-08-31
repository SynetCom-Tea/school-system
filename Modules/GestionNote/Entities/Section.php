<?php

namespace Modules\GestionNote\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'libelle'];
}
