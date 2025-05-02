<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Liste d'Infractions</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('assets/img/icon.png') }}" />
</head>
<body>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar sticky">
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn"> <i data-feather="align-justify"></i></a></li>
                    </ul>
                </div>
                <ul class="navbar-nav navbar-right">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-left">
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="#"> <img alt="image" src="assets/img/logo.png" class="header-logo" /> <span class="logo-name"></span></a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Main</li>
                        <li class="dropdown">
                            <a href="{{ route('home') }}" class="nav-link"><i data-feather="map"></i><span>Recherche d'Infractions</span></a>
                        </li>
                        <li class="dropdown">
                            <a href="{{ route('admin.statistiques') }}" class="nav-link"><i data-feather="activity"></i><span>Statistique</span></a>
                        </li>
                        <li class="dropdown">
                            <a href="{{ route('admin.ajout') }}" class="nav-link"><i data-feather="map-pin"></i><span>Ajouter une Infraction</span></a>
                        </li>
                        
                    </ul>
                </aside>
            </div>
            <div class="main-content">
                <section class="section">
                    <div class="section-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Les Infractions</h4>
                                    </div>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <form action="{{ route('infractions.index') }}" method="GET" class="mx-auto" style="width: 100%;">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="communeInput">Commune :</label>
                                                            <input type="text" class="form-control" name="commune" id="communeInput" placeholder="Entrez la commune">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                        <label class="form-label">Mois/annee L'infraction *</label>
                                                        <input type="month" class="form-control" name="nom_infraction" id="infractionInput" placeholder="Entrez Mois/annee L'infraction">
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <button class="btn btn-primary btn-block" type="submit">Rechercher</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th>Commune</th>
                                                        <th>Mois/annee L'infraction</th>
                                                        <th>Date de L'infraction</th>
                                                        <th>Nature de L'infraction</th>
                                                        <th>Contrevenant</th>
                                                        <th>Adresse</th>
                                                        <th>Décision</th>
                                                        <th>Action</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($informations as $information)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $information->commune }}</td>
                                                            <td>{{ $information->nom_infraction }}</td>
                                                            <td>{{ $information->date_infraction }}</td>
                                                            <td>{{ $information->categorie_infraction }}</td>
                                                            <td>{{ $information->nom_contrevenant }} {{ $information->prenom_contrevenant }}</td>
                                                            <td>{{ $information->adresse_contrevenant }}</td>
                                                            <td>
                                                                <div class="badge badge-{{ $information->decision == 'completed' ? 'success' : 'warning' }} badge-shadow">
                                                                    {{ $information->decision }}
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <form action="{{ route('toggle.decision', $information->id_information) }}" method="POST" style="display: inline;">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-icon btn-primary">
                                                                        <i class="far fa-edit"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                            <td>
                                                                <form action="{{ route('delete.infraction', $information->id_information) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-icon btn-danger">
                                                                        <i class="far fa-trash-alt"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/export-tables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/export-tables/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/export-tables/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/export-tables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/export-tables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/export-tables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/page/datatables.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>
</html>
