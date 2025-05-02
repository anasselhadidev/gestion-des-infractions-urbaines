<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Ajouter une Infraction</title>
    
  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/css/app.min.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="assets/css/custom.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.4.2/uicons-solid-rounded/css/uicons-solid-rounded.css'>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css'>
  <link rel="stylesheet" href="./style.css">
  <style>
    #map { height: 300px; width: 100%; }
  </style>
  <link rel='shortcut icon' type='image/x-icon' href='assets/img/icon.png' />
</head>

<body>
  <x-app-layout>
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li>
              <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn">
                <i data-feather="align-justify"></i>
              </a>
            </li>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
          <!-- Bouton de déconnexion -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-user"></i> 
            </a>
            <div class="dropdown-menu dropdown-menu-left">
              <a class="dropdown-item" href="{{ route('logout') }}"
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
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <!-- Formulaire -->
            <form method="post" action="{{ route('infractions.store') }}">
              @csrf <!-- Ajouter le jeton CSRF ici -->
              <div class="container">
                <div id="app">
                  <step-navigation :steps="steps" :currentstep="currentstep"></step-navigation>
                  <div v-show="currentstep == 1">
                    <div>
                      <h6></h6>
                    </div>
                    <div class="row mb-4">
                      <div class="col-12 col-md-6 col-lg-4">
                        <div class="input-group">
                          <input type="text" class="form-control" id="input-lat" name="latitude" placeholder="Latitude">
                          <input type="text" class="form-control" id="input-lng" name="longitude" placeholder="Longitude">
                          <button class="btn btn-outline-primary" id="btn-current-location">utiliser ma position actuelle</button>

                        </div>
                      </div>
                    </div>
                   
                    <div id="map"></div>
                  </div>
                  <div v-show="currentstep == 2">
                    <!-- <h1>Step 2</h1> -->
                    <fieldset>
                    <div class="form-group form-float">
                        <div class="form-line">
                          <label class="form-label">Mois/annee L'infraction *</label>
                          <input type="month" class="form-control" name="nom_infraction" >

                        </div>
                      </div>
                      
                      <div class="form-group form-float">
                        <div class="form-line">
                          <label class="form-label">Commune *</label>
                          <div class="form-group">
                          <input type="text" class="form-control" name="commune" >

                          </div>
                        </div>
                      </div>
                      <div class="form-group form-float">
                        <div class="form-line">
                          <label class="form-label">Date de contrôle *</label>
                          <input type="date" class="form-control" name="date_infraction" required>
                        </div>
                      </div>
                      <div class="form-group form-float">
                        <div class="form-line">
                          <label class="form-label">Nature de l'Infraction *</label>
                          <div class="form-group">
                          <select class="form-control select2" name="categorie_infraction">
                            <option value="sans permis préalable">sans permis préalable</option>
                            <option value="Sans respecter les dispositions des documents écrits et graphiques relatifs aux permis délivrés à cet égard">Sans respecter les dispositions des documents écrits et graphiques relatifs aux permis délivrés à cet égard</option>
                            <option value="Dans une zone non susceptible de les accueillir en vertu des règlements en vigueur">Dans une zone non susceptible de les accueillir en vertu des règlements en vigueur</option>
                            <option value="Sur une propriété relevant du domaine public ou privé de l'État et des collectivités territoriales">Sur une propriété relevant du domaine public ou privé de l'État et des collectivités territoriales</option>
                            <option value="L'usage d'un bâtiment sans l'obtention d'un permis d'habiter ou d'un certificat de conformité">L'usage d'un bâtiment sans l'obtention d'un permis d'habiter ou d'un certificat de conformité</option>
                            <option value="L'accomplissement des actes interdits en vertu du 2ème alinéa de l'article 34 de la présente loi.">L'accomplissement des actes interdits en vertu du 2ème alinéa de l'article 34 de la présente loi.</option>
                            <option value="Tout manquement aux dispositions du premier alinéa de l'article 54-2 ci-dessus relatives à la tenue">Tout manquement aux dispositions du premier alinéa de l'article 54-2 ci-dessus relatives à la tenue</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </fieldset>
                  </div>
                  <div v-show="currentstep == 3">
                    <!-- <h1>Step 3</h1> -->
                    <fieldset>
                      <div class="form-group form-float">
                        <div class="form-line">
                          <label class="form-label">CINE du contrevenant *</label>
                          <input type="text" class="form-control" name="cine_contrevenant">
                        </div>
                      </div>
                      <div class="form-group form-float">
                        <div class="form-line">
                          <label class="form-label">Prenom du contrevenant *</label>
                          <input type="text" class="form-control" name="prenom_contrevenant">
                        </div>
                      </div>
                      <div class="form-group form-float">
                        <div class="form-line">
                          <label class="form-label">Nom du contrevenant *</label>
                          <input type="text" class="form-control" name="nom_contrevenant">
                        </div>
                      </div>
                      <div class="form-group form-float">
                        <div class="form-line">
                          <label class="form-label">adresse de residence *</label>
                          <input type="text" class="form-control" name="adresse_contrevenant">
                        </div>
                      </div>
                    </fieldset>
                  </div>
                  <div v-show="currentstep == 4">
                    <!-- <h1>Step 4</h1> -->
                    <fieldset>
                      <div class="form-group form-float">
                        <div class="form-line">
                          <label class="form-label">CINE de l'agent *</label>
                          <input type="text" class="form-control" name="cine_agent">
                        </div>
                      </div>
                      <div class="form-group form-float">
                        <div class="form-line">
                          <label class="form-label">Nom de l'agent *</label>
                          <input type="text" class="form-control" name="nom_agent">
                        </div>
                      </div>
                      <div class="form-group form-float">
                        <div class="form-line">
                          <label class="form-label">prenom de l'agent *</label>
                          <input type="text" class="form-control" name="prenom_agent">
                        </div>
                      </div>
                      <div class="form-group form-float">
                        <div class="form-line">
                          <label class="form-label">Tel de l'agent *</label>
                          <input type="text" class="form-control" name="tel_agent">
                        </div>
                      </div>
                    </fieldset>
                  </div>
                  <step v-for="step in steps" :currentstep="currentstep" :key="step.id" :step="step" :stepcount="steps.length" @step-change="stepChanged"></step>
                  <script type="x-template" id="step-navigation-template">
                    <ol class="step-indicator">
                      <li v-for="step in steps" is="step-navigation-step" :key="step.id" :step="step" :currentstep="currentstep"></li>
                    </ol>
                  </script>
                  <script type="x-template" id="step-navigation-step-template">
                    <li :class="indicatorclass">
                      <div class="step"><i :class="step.icon_class"></i></div>
                      <div class="caption hidden-xs hidden-sm"><span v-text="step.id"></span><span v-text="step.title"></span></div>
                    </li>
                  </script>
                  <script type="x-template" id="step-template">
                    <div class="step-wrapper" :class="stepWrapperClass">
                      <button type="button" class="btn btn-primary" @click="lastStep" :disabled="firststep">Précédent</button>
                      <button type="button" class="btn btn-primary" @click="nextStep" :disabled="laststep">Suivant</button>
                      <button type="submit" class="btn btn-primary" v-if="laststep">Sauvegarder</button>
                    </div>
                  </script>
                </div>
              </div>
            </form>
          </div>
        </section>
      </div>
    </div>
  </x-app-layout>
  
  <!-- General JS Scripts -->
  <script src="assets/js/app.min.js"></script>
  <!-- JS Libraries -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.4.4/vue.js'></script>
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="assets/js/custom.js"></script>
  <script src="./script.js"></script>
</body>
</html>

