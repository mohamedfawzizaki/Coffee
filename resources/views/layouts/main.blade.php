<!doctype html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}"  data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="enable" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

<head>

    <meta charset="utf-8" />
    <title> {{ $setting->title }} | @isset($title) @lang($title) @endisset</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="syntech" name="description" />
    <meta content="syntech" name="author" />
    <link rel="shortcut icon" href="{{ $setting->favicon }}">
    <link href="{{ asset('main/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('main/libs/swiper/swiper-bundle.min.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('main/js/layout.js')}}"></script>
    <link href="{{ asset('main/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('main/css/custom.min.css')}}" rel="stylesheet" type="text/css" />

    @if (LaravelLocalization::getCurrentLocale() == 'ar')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

    <link href="{{ asset('main/css/bootstrap-rtl.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('main/css/app-rtl.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('main/css/rtl.css')}}" rel="stylesheet" type="text/css" />
    @else

    <link href="{{ asset('main/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('main/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    @endif
    <link href="{{ asset('main/css/custom.css')}}" rel="stylesheet" type="text/css" />

    @livewireStyles

    @stack('css')

</head>

<body>

    <div id="layout-wrapper">

    @livewire('dashboard.component.header')

    @livewire('dashboard.component.sidebar')

        <div class="vertical-overlay"></div>

        <div class="main-content">

            {{ $slot }}

        </div>

            {{--  <footer class="footer border-top">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script> © Velzon.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Design & Develop by <a href="https://syntecheg.com/" target="_blank">Syntech</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>  --}}
        </div>

    </div>


    <button onclick="topFunction()" class="btn btn-primary btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>

{{--
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>  --}}





    <script src="{{ asset('main/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('main/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{ asset('main/libs/node-waves/waves.min.js')}}"></script>
    <script src="{{ asset('main/libs/feather-icons/feather.min.js')}}"></script>
    <script src="{{ asset('main/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
    <script src="{{ asset('main/js/plugins.js')}}"></script>
    <script src="{{ asset('main/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{ asset('main/libs/jsvectormap/js/jsvectormap.min.js')}}"></script>
    <script src="{{ asset('main/libs/jsvectormap/maps/world-merc.js')}}"></script>
    <script src="{{ asset('main/libs/swiper/swiper-bundle.min.js')}}"></script>
    {{--  <script src="{{ asset('main/js/pages/dashboard-ecommerce.init.js')}}"></script>  --}}
    <script src="{{ asset('main/js/app.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/lightgallery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/css/lightgallery.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @livewireScripts

    <script>

        document.addEventListener('livewire:initialized', () => {
            Livewire.on('showAlert', (data) => {
                Swal.fire({
                    icon: data.type,
                    title: data.message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            });
        });

        @if(Session::has('success'))
            Swal.fire({
                icon: 'success',
                title: "{{ Session::get('success') }}",
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        @endif

        @if(Session::has('error'))
            Swal.fire({
                icon: 'error',
                title: "{{ Session::get('error') }}",
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        @endif


    </script>

    @stack('js')


</body>

</html>
