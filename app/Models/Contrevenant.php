<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrevenant extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'cine_contrevenant', 'prenom_contrevenant', 'nom_contrevenant', 'adresse_contrevenant',
    ];
}
