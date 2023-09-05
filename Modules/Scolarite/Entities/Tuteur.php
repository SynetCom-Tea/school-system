<?php

namespace Modules\Scolarite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\HasMany;
=======
>>>>>>> ad5d54d4764568131cc3b25525407468aeefc0bb

class Tuteur extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $fillable = ['nom','prenom','tel','adresse'];
    
    public function apprenants(): HasMany
    {
        return $this->hasMany(Apprenant::class);
=======
    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Scolarite\Database\factories\TuteurFactory::new();
>>>>>>> ad5d54d4764568131cc3b25525407468aeefc0bb
    }
}
