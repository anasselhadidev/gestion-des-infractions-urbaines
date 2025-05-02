<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;
    protected $table = 'information'; // Assurez-vous que cela correspond à votre table
    protected $primaryKey = 'id_information'; // Spécifiez la clé primaire
    public $timestamps = false;
    protected $fillable = [
        'nom_infraction', 'commune', 'date_infraction', 'categorie_infraction','prenom_contrevenant','nom_contrevenant','adresse_contrevenant','decision','latitude','longitude'
    ];
}
