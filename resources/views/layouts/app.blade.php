 <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" id="csrf_token" content="{{ csrf_token() }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Script Files -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.3/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/swal_popup.js') }}" defer></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    
    <!-- CSS Files -->
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
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Health Care</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <!-- Side Bar -->
        <div class="offcanvas-body small">
            <ul class="sidebar-list  pl-0" >
                <div class="text-center">
                    <img src="{{asset('/images/user.png')}}" class="text-center">
                </div>
                <li class="dropdown-item h4 mt-2 text-center">{{auth()->user()->name}}</li>
                <li class="dropdown-item text-center">{{auth()->user()->email}}</li>
                @if(auth()->user()->role_id == \App\Models\Role::ROLE_ADMIN)
                <li><a class="dropdown-item h5 my-3" href="{{url('admin')}}"><img src="{{asset('/images/dashboard.png')}}" class="me-3">Dashboard</a></li>
                <li><a class="dropdown-item h5 my-3" href="{{url('doctor/create')}}"><img src="{{asset('/images/doctor-add.png')}}" class="me-3">Add Doctor</a></li>
                <li><a class="dropdown-item h5 my-3" href="{{url('doctor')}}"><img src="{{asset('/images/doctor.png')}}" class="me-3">Doctors</a></li>
                <li><a class="dropdown-item h5 my-3" href="{{url('appointment_lists')}}"><img src="{{asset('/images/appoinments.png')}}" class="me-3">Appointments</a></li>
                <li><a class="dropdown-item h5 my-3" href="{{url('patient_lists')}}"><img src="{{asset('/images/patient.png')}}" class="me-3">Patients</a></li>
                @endif
                @if(auth()->user()->role_id == \App\Models\Role::ROLE_DOCTOR)
                <li><a class="dropdown-item h5 my-3" href="{{url('doctor_dashboard')}}"><img src="{{asset('/images/dashboard.png')}}" class="me-3">Dashboard</a></li>
                <li><a class="dropdown-item h5 my-3" href="{{url('doctor_profile/' .auth()->id())}}"><img src="{{asset('/images/profile.png')}}" class="me-3">My Profile</a></li>
                <li><a class="dropdown-item h5 my-3" href="{{url('doctor_appointments')}}"><img src="{{asset('/images/appoinments.png')}}" class="me-3">My Appointments</a></li>
                @endif
                @if(auth()->user()->role_id == \App\Models\Role::ROLE_PATIENT)
                <li>
                    <a class="dropdown-item h6 my-3 py-2" href="{{url('patient')}}"><img src="{{asset('/images/dashboard.png')}}" class="me-3">Dashboard</a>
                </li>
                <li><a class="dropdown-item h6 my-3 py-2" href="{{url('patient/'. auth()->id())}}"> <img src="{{asset('/images/profile.png')}}" class="me-3">My Profile</a></li>
                <li><a class="dropdown-item h6 my-3 py-2" href="{{url('appointment/create')}}"><img src="{{asset('/images/schedule.png')}}" class="me-3">Schedule an Appointment</a></li>
                <li><a class="dropdown-item h6 my-3 py-2" href="{{url('appointment')}}"><img src="{{asset('/images/appoinments.png')}}" class="me-3">My Appointments</a></li>
                @endif
            </ul>
            <a class="dropdown-item h6 mt-5 py-2 " href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><img src="{{asset('/images/logout.png')}}" class="me-3">Log Out</a>
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
                <img src="{{asset('/images/humburger-icon.png')}}" style="height:20px">
            </button>
            @endauth

            <!-- Nav Bar -->
            <div class="container ms-0">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{asset('/images/logo.PNG')}}" class="logo">
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

        <!-- Content -->
        <main class="py-4">
            @yield('content')
        </main>
    </div>

  
</body>
@stack('js')
</html>