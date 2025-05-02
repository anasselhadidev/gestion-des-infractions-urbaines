<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Agence Urbaine de Beni Mellal</title>
  <link rel="stylesheet" href="assets/css/app.min.css">
  <link rel="stylesheet" href="assets/bundles/bootstrap-social/bootstrap-social.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <link rel="stylesheet" href="assets/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href='assets/img/icon.png' />
  <script src="https://cdn.lordicon.com/lordicon.js"></script>
</head>
<body>
  <div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">
              <div class="card-header" style="justify-content: flex-start;">
                <img style="width: 60px;" src="assets/img/icon.png" alt="">
                <h4>Se Connecter</h4>
              </div>
              <div class="card-body">
                <x-validation-errors class="mb-4" />
                @if (session('status'))
                  <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                  </div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                  @csrf
                  <div class="form-group">
                    <label>Email</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <lord-icon src="https://cdn.lordicon.com/bgebyztw.json" trigger="loop" stroke="bold" state="hover-looking-around" colors="primary:#495057,secondary:#34a0a4" style="width:30px;height:30px"></lord-icon>
                        </div>
                      </div>
                      <input type="email" class="form-control" name="email" :value="old('email')" required autofocus autocomplete="username">
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <lord-icon src="https://cdn.lordicon.com/vfczflna.json" trigger="loop" stroke="bold" state="hover-cross" colors="primary:#495057,secondary:#34a0a4" style="width:30px;height:30px"></lord-icon>
                        </div>
                      </div>
                      <input type="password" class="form-control" name="password" required autocomplete="current-password">
                    </div>
                  </div>
                  <div class="block mt-4">
                    <label for="remember_me" class="flex items-center">
                      <x-checkbox id="remember_me" name="remember" />
                      <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                  </div>
                  <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                      <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                      </a>
                    @endif
                    <button type="submit" class="ms-4 btn btn-primary">
                      {{ __('Log in') }}
                    </button>
                  </div>
                </form>
                <div class="text-center mt-4 mb-3">
                  <div class="text-job text-muted">Agence Urbaine de Beni Mellal</div>
                </div>
              </div>
            </div>
            <div class="mt-5 text-muted text-center">
              Vous n'avez pas de compte ? <a href="{{ route('register') }}">Crée un compte</a>
            </div> 
          </div>
        </div>
      </div>
    </section>
  </div>
  <script src="assets/js/app.min.js"></script>
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>
