<head>
 <meta charset="UTF-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0" />
 <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<div class="container mb-3">
  <div class="row">
    <ul class="nav justify-content-center">
      <li class="nav-item">
        <a class="btn {{ Request::path() === 'statistics' || Request::path() === '/' ? 'btn-dark' : 'btn-secondary'}}" href="{{ route('statistics_index') }}">Statistics</a>
      </li>
      <li class="nav-item">
        <a class="btn {{ Request::path() === 'files' ? 'btn-dark' : 'btn-secondary'}}" href="{{ route('files_index') }}">Files</a>
      </li>
      <li class="nav-item">
        <a class="btn {{ Request::path() === 'settings' ? 'btn-dark' : 'btn-secondary'}}" href="{{ route('settings_index') }}">Settings</a>
      </li>
    </ul>
  </div>
</div>
