<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Login To Continue</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
    />
  

    <style>
        .log-1 {
                height: 80vh;
                width: 80vw;
                }

        body {
        height: 100vh;
        }
    </style>
  </head>

  <body class="d-flex justify-content-center align-items-center">
    <div class="row justify-content-center mx-0 log-1 align-items-center">
      <div
        class="col-md-4 shadow-sm p-4 bg-light rounded border border-secondary-subtle"
      >
        <div class="logo101 d-flex justify-content-center">
          <img
            src="{{asset('logo.png')}}"
            alt="NOLITC-logo"
            height="250px"
            class="p-3"
          />
        </div>
        <form action="{{ route('login') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input
              type="text"
              class="form-control shadow-none"
              name="username"
              autofocus
              autocomplete="off"
            />
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <input
              type="password"
              class="form-control shadow-none"
              name="password"
              autocomplete="off"
            />
          </div>

          @if(session('message'))
          <p class="text-danger mt-3">{{ session('message') }}</p>
          @endif

          <button type="submit" class="btn btn-success w-100">Login</button>
        </form>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
