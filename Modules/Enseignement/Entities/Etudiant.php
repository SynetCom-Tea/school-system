<?php

namespace Modules\Enseignement\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $table = 'etudiants';
    protected $primarykey = 'id';
    protected $fillable = ['id','matricule','nom','prenom','civilite','nom_complete','nom_jeune_fille','date_naiss','lieu_naiss','nationalite','extrait_naiss','extrait_nation','handicap' ,'sexe','adress1','adress2','localite','tel','mail','profession_pere','profession_mere','photo'];
    use HasFactory;
}
