<?php

namespace Modules\GestionNote\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    use HasFactory;
    protected $table = 'enseignants';
    protected $primarykey = 'id';
    protected $fillable = ['id','nom','prenom','sexe','telephone','mail'];
}
