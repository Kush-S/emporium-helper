<head>
 <meta charset="UTF-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0" />
 <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<div class="container my-5">
  <div class="row">
    <ul class="nav justify-content-center">
      <li class="nav-item">
        <a class="btn {{ Request::path() === 'files' || Request::path() === '/' ? 'btn-secondary' : 'btn-primary'}}" href="{{ route('files_index') }}">Files</a>
      </li>
      <li class="nav-item">
        <a class="btn {{ Request::path() === 'settings' ? 'btn-secondary' : 'btn-primary'}}" href="{{ route('settings_index') }}">Settings</a>
      </li>
    </ul>
  </div>
</div>
