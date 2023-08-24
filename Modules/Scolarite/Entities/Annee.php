<?php

namespace Modules\Scolarite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Annee extends Model
{
    use HasFactory;

    protected $fillable = ['annee'];
}
