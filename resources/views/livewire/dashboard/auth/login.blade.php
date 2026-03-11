<!doctype html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}"  data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="enable" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

<head>

    <meta charset="utf-8" />
    <title>{{ $setting->title }} | @lang('Sign In') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="syntech" name="author" />
    <link rel="shortcut icon" href="{{ $setting->favicon }}">
    <script src="{{ asset('main/js/layout.js')}}"></script>
    <link href="{{ asset('main/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('main/css/custom.min.css')}}" rel="stylesheet" type="text/css" />

    @if (LaravelLocalization::getCurrentLocale() == 'ar')

    <style>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

    </style>

    <link href="{{ asset('main/css/bootstrap-rtl.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('main/css/app-rtl.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('main/css/rtl.css')}}" rel="stylesheet" type="text/css" />
    @else

    <link href="{{ asset('main/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('main/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    @endif
    <link href="{{ asset('main/css/custom.css')}}" rel="stylesheet" type="text/css" />


    <style>
        body {
            background-image: url('{{ asset('images/chat-bg-pattern.png') }}') !important;
            background-attachment: fixed;
          }

          .auth-bg-cover {
            background: linear-gradient(-45deg,#0f4954 50%,var(--vz-success));
          }


    </style>
</head>

<body>


    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>

        <div class="auth-page-content overflow-hidden pt-lg-5">


            <div class="container">




                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card overflow-hidden card-bg-fill border-0 card-border-effect-none">
                            <div class="row g-0">

                                <div class="col-lg-12">

                                    <div class="p-lg-5 p-4">

                                        <div class="text-center">
                                            <a href="#" class="d-block mb-4">
                                                <img src="{{ $setting->logo }}" alt="" height="50">
                                            </a>
                                        </div>

                                        <div class="d-flex justify-content-end mb-3">
                                            <div class="header-element country-selector">
                                                <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-auto-close="outside" data-bs-toggle="dropdown">
                                                    <img src="{{ asset('images/flags/' . App::currentLocale().'.svg')}}" alt="img" class="rounded-circle header-link-icon">
                                                </a>

                                                <ul class="dropdown-menu dropdown-menu-end" data-popper-placement="none">
                                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                        <li>
                                                            <a class="dropdown-item d-flex align-items-center" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                                                <span class="avatar avatar-xs lh-1 me-2">
                                                                    <img src="{{ asset('images/flags/' . $localeCode.'.svg')}}" alt="img">
                                                                </span>
                                                                {{ $properties['native'] }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>



                                        <div>
                                            <h5 class="text-primary"> @lang('Welcome Back !')</h5>
                                            <p class="text-muted"> @lang('Sign in to continue') </p>
                                        </div>

                                        <div class="mt-4">

                                            <form action="{{ route('dashboard.postlogin') }}" method="post">
                                                @csrf

                                                <div class="mb-3">
                                                    <label for="email" class="form-label">@lang('Email')</label>
                                                    <input type="email" class="form-control" id="email" placeholder="@lang('Enter your email')" name="email" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="password-input">@lang('Password')</label>
                                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                                        <input type="password" class="form-control pe-5 password-input" placeholder="@lang('Enter your password')" id="password-input" name="password" required>
                                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon">
                                                            <i class="ri-eye-fill align-middle"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="mt-4">
                                                    <button class="btn btn-primary w-100" type="submit">@lang('Sign In')</button>
                                                </div>

                                            </form>
                                        </div>


                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0">&copy;
                                <script>document.write(new Date().getFullYear())</script> by  <a href="https://syntecheg.com/" target="_blank" style="color: #fff;">Syntech</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </div>

    <script src="{{ asset('main/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('main/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{ asset('main/libs/node-waves/waves.min.js')}}"></script>
    <script src="{{ asset('main/libs/feather-icons/feather.min.js')}}"></script>
    <script src="{{ asset('main/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
    <script src="{{ asset('main/js/plugins.js')}}"></script>
    <script src="{{ asset('main/js/pages/password-addon.init.js')}}"></script>
</body>

</html>
