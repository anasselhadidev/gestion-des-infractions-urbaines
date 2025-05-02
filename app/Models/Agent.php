<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'cine_agent', 'nom_agent', 'prenom_agent', 'tel_agent',
    ];
}

