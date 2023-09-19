 <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" id="csrf_token" content="{{ csrf_token() }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- scripts --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.3/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/swal_popup.js') }}" defer></script>
    
    {{-- css files --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.3/dist/sweetalert2.min.css">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('css')
</head>
<body>
    <div id="app">
        @auth
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Health Clinic</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        {{-- sidebar --}}
        <div class="offcanvas-body small">
            <ul >
                <li class="dropdown-item">{{auth()->user()->name}}</li>
                <li class="dropdown-item">{{auth()->user()->email}}</li>
                @if(auth()->user()->role_id == \App\Models\Role::ROLE_ADMIN)
                <li><a class="dropdown-item" href="{{url('admin')}}">Dashboard</a></li>
                <li><a class="dropdown-item" href="{{url('doctor/create')}}">Add Doctor</a></li>
                <li><a class="dropdown-item" href="{{url('doctor')}}">Doctors</a></li>
                <li><a class="dropdown-item" href="{{url('appointment_lists')}}">Appointments</a></li>
                <li><a class="dropdown-item" href="{{url('patient_lists')}}">Patients</a></li>
                @endif
                @if(auth()->user()->role_id == \App\Models\Role::ROLE_DOCTOR)
                <li><a class="dropdown-item" href="{{url('doctor_dashboard')}}">Dashboard</a></li>
                <li><a class="dropdown-item" href="{{url('doctor_appointments')}}">My Appointments</a></li>
                @endif
                @if(auth()->user()->role_id == \App\Models\Role::ROLE_PATIENT)
                <li><a class="dropdown-item" href="{{url('patient')}}">Dashboard</a></li>
                <li><a class="dropdown-item" href="{{url('patient/'. auth()->id())}}">My Profile</a></li>
                <li><a class="dropdown-item" href="{{url('appointment/create')}}">Schedule an Appointment</a></li>
                <li><a class="dropdown-item" href="{{url('appointment')}}">My Appointments</a></li>
                @endif
            </ul>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            </div>
        </div>
        </div>
        @endauth
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            @auth
            <button data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample" class="humburger-icon ms-3">
                <img src="{{url('/images/humburger-icon.png')}}" style="height:20px">
            </button>
            @endauth

            {{-- navbar --}}
            <div class="container ms-0">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{url('/images/logo.PNG')}}" class="logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto"></ul>
                    <ul class="navbar-nav ms-auto">
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <button class="login-link">
                                <a class="nav-link login-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </button>
                        </li>
                        @endif
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <button class="register-link ms-2">
                                <a class="nav-link register-link"
                                    href="{{ route('register') }}">{{ __('Register') }}</a>
                            </button>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown h4">
                            <a id="navbarDropdown1" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        {{-- content --}}
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
@stack('js')
</html>