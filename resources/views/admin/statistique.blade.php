<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Statistique</title>
  <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
  <link rel='shortcut icon' type='image/x-icon' href='assets/img/icon.png' />
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <style>
    #map { height: 500px; width: 100%; }
  </style>
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
            <a href="#"> <img alt="image" src="{{ asset('assets/img/logo.png') }}" class="header-logo" /> <span class="logo-name"></span></a>
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
                    <h4>Statistiques</h4>
                  </div>
                  <div class="card-body">
                    <form action="{{ route('infractions.statistiques') }}" method="get">
                      @csrf
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="communeInput">Commune :</label>
                          <input type="text" class="form-control" name="commune" id="communeInput" placeholder="Entrez la commune">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputState">Nature D'infraction</label>
                          <select id="inputState" name="categorie_infraction" class="form-control">
                            <option value="Option 1">sans permis préalable</option>
                            <option value="Option 2">Sans respecter les dispositions des documents écrits et graphiques relatifs aux permis délivrés à cet égard</option>
                            <option value="Option 3">Dans une zone non susceptible de les accueillir en vertu des règlements en vigueur</option>
                            <option value="Option 1">Sur une propriété relevant du domaine public ou privé de l'État et des collectivités territoriales</option>
                            <option value="Option 1">L'usage d'un bâtiment sans l'obtention d'un permis d'habiter ou d'un certificat de conformité</option>
                            <option value="Option 1">L'accomplissement des actes interdits en vertu du 2ème alinéa de l'article 34 de la présente loi.</option>
                            <option value="Option 1">Tout manquement aux dispositions du premier alinéa de l'article 54-2 ci-dessus relatives à la tenue</option>
                          </select>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="dateDebut">Date Début</label>
                          <input type="date" class="form-control" name="date_debut" id="dateDebut">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="dateFin">Date Fin</label>
                          <input type="date" class="form-control" name="date_fin" id="dateFin">
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <button type="reset" class="btn btn-secondary" onclick="window.location='{{ route('infractions.statistiques') }}'">Reset</button>
                    </form>
                  </div>
                  <div class="card-footer">
                    <div id="map"></div>
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
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>
  <script>
    var map = L.map('map').setView([0, 0], 2);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var redIcon = new L.Icon({
      iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
      iconSize: [25, 41],
      iconAnchor: [12, 41],
      popupAnchor: [1, -34],
      shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.4/images/marker-shadow.png',
      shadowSize: [41, 41]
    });

    function addMarkers(infractions) {
      infractions.forEach(function(infraction) {
        if (infraction.latitude && infraction.longitude) {
          L.marker([infraction.latitude, infraction.longitude], { icon: redIcon })
            .addTo(map)
            .bindPopup("<b>" + infraction.categorie_infraction + "</b><br>" + infraction.commune + "<br>" + infraction.date_infraction);
        }
      });
    }

    @if(isset($infractions))
      addMarkers(@json($infractions));
    @endif
  </script>
</body>

</html>
