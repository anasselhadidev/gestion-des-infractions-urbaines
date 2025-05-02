<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Localisation;
use App\Models\Information;
use App\Models\Contrevenant;
use App\Models\Agent;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::id())
        {
            $user_type = Auth()->user()->usertype;
            $useryes = Auth()->user()->useryes;
            if($user_type == 'admin')
            {
                $informations = Information::all();
                return view('admin.show_infraction', compact('informations'));
            }
            else if ($user_type == 'user' and $useryes == 'yes')
            {
                return view('useryes.index');
            }
            else if ($user_type == 'user')
            {
                return view('home.index');
            }        
        }
        else 
        {
            return redirect()->back();
        }
    }

    public function toggleDecision($id_information)
    {
        $information = Information::find($id_information);
        
        if ($information->decision == 'en cours') {
            $information->decision = 'completed';
        } else {
            $information->decision = 'en cours';
        }
        
        $information->save();

        return redirect()->back();
    }
    public function deleteInfraction($id_information)
    {
        $information = Information::find($id_information);
        
        if ($information) {
            $information->delete();
        }

        return redirect()->back();
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/'); // Redirige vers la page d'accueil ou toute autre page après la déconnexion
    }
    public function recherche(Request $request)
    {
        $query = Information::query();

        if ($request->filled('commune')) {
            $query->where('commune', $request->commune);
        }

        if ($request->filled('nom_infraction')) {
            $query->where('nom_infraction', 'like', '%' . $request->nom_infraction . '%');
        }

        $informations = $query->get();

        return view('admin.show_infraction', compact('informations'));
    }
    public function statistiques()
    {
        return view('admin.statistique');
    }
    public function index1()
    {
        return view('admin.index1');
    }
    public function store1(Request $request)
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

        return redirect()->route('admin.ajout')->with('success', 'Données sauvegardées avec succès !');
    }
    public function statistiquees(Request $request)
{
    $request->validate([
        'commune' => 'nullable|string|max:255',
        'categorie_infraction' => 'nullable|string|max:255',
        'date_debut' => 'nullable|date',
        'date_fin' => 'nullable|date|after_or_equal:date_debut',
    ]);

    $query = Information::query();

    if ($request->filled('commune')) {
        $query->where('commune', $request->input('commune'));
    }

    if ($request->filled('categorie_infraction')) {
        $query->where('categorie_infraction', $request->input('categorie_infraction'));
    }

    if ($request->filled('date_debut') && $request->filled('date_fin')) {
        $query->whereBetween('date_infraction', [$request->input('date_debut'), $request->input('date_fin')]);
    }

    $infractions = $query->get(['latitude', 'longitude', 'categorie_infraction', 'commune', 'date_infraction']);

    return view('admin.statistique', compact('infractions'));
}

}
