<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Localisation;
use App\Models\Information;
use App\Models\Contrevenant;
use App\Models\Agent;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'nom_infraction' => 'required|string|max:255',
            'commune' => 'required|string|max:255',
            'date_infraction' => 'required|date',
            'categorie_infraction' => 'required|string|max:255',
            'cine_contrevenant' => 'required|string|max:50',
            'prenom_contrevenant' => 'required|string|max:255',
            'nom_contrevenant' => 'required|string|max:255',
            'adresse_contrevenant' => 'required|string',
            'cine_agent' => 'required|string|max:50',
            'nom_agent' => 'required|string|max:255',
            'prenom_agent' => 'required|string|max:255',
            'tel_agent' => 'required|string|max:20',
        ]);

        $localisation = Localisation::create([
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude']
        ]);

        $information = Information::create([
            'nom_infraction' => $data['nom_infraction'],
            'commune' => $data['commune'],
            'date_infraction' => $data['date_infraction'],
            'categorie_infraction' => $data['categorie_infraction'],
            'prenom_contrevenant' => $data['prenom_contrevenant'],
            'nom_contrevenant' => $data['nom_contrevenant'],
            'adresse_contrevenant' => $data['adresse_contrevenant'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude']
        ]);

        $contrevenant = Contrevenant::create([
            'cine_contrevenant' => $data['cine_contrevenant'],
            'prenom_contrevenant' => $data['prenom_contrevenant'],
            'nom_contrevenant' => $data['nom_contrevenant'],
            'adresse_contrevenant' => $data['adresse_contrevenant']
        ]);

        $agent = Agent::create([
            'cine_agent' => $data['cine_agent'],
            'nom_agent' => $data['nom_agent'],
            'prenom_agent' => $data['prenom_agent'],
            'tel_agent' => $data['tel_agent']
        ]);

        return redirect()->route('home')->with('success', 'Données sauvegardées avec succès !');
    }
}
