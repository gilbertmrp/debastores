<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    
    <base href="/public">
    @yield('style')
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.js" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.css" rel="stylesheet" />
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <style>
        
    </style>
</head>

<body style="height: 100%;">
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-primary fixed-top">
            <!-- Container wrapper -->
            <div class="container-fluid">
                <!-- Toggle button -->
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
                    data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <!-- Collapsible wrapper -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Navbar brand -->
                    <a class="navbar-brand mt-2 mt-lg-0" href="{{ url('/') }}">
                        <img src="img/deba.png" height="45" alt="logo Deba" loading="lazy" />
                    </a>
                    <!-- Left links -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/list-menu">Menu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/contact') }}">Pesan Tempat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/aboutususer">Article</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/review') }}">Review</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/image') }}">Gallery</a>
                        </li>
                    </ul>
                    <!-- Left links -->
                </div>
                <!-- Collapsible wrapper -->

                <!-- Right elements -->
                <div class="d-flex align-items-center">
                    @guest
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="nav-link text-white">Login</a>
                        @endif

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"><button type="button" class="btn btn-primary">SIGN UP FOR
                                    FREE</button></a>
                        @endif
                    @endguest
                    <!-- Icon -->
                    @if (Route::has('login'))
                        @auth
                        {{-- @php $orders = \DB::select("SELECT * from pesanans where status = 3 and user_id = ".{{ Auth::user()->id }});
                             $packing = \DB::select("SELECT * from pesanans where status = 4");
                             $tracking = \DB::select("SELECT * from pesanans where status = 5");
                        @endphp --}}
                        @php $orders = \DB::table("pesanans")
                                        ->where('status', 3)
                                        ->where('user_id', Auth::user()->id)
                                        ->get();
                        $packing = \DB::table("pesanans")
                                        ->where('status', 4)
                                        ->where('user_id', Auth::user()->id)
                                        ->get();;
                        $tracking = \DB::table("pesanans")
                                        ->where('status', 5)
                                        ->where('user_id', Auth::user()->id)
                                        ->get();;
                        @endphp
                        <div class="dropdown">
                            <a
                              class="text-reset me-3 dropdown-toggle hidden-arrow"
                              href="#"
                              id="navbarDropdownMenuLink"
                              role="button"
                              data-mdb-toggle="dropdown"
                              aria-expanded="false"
                            >
                              <i class="fas fa-bell"></i>
                              <span class="badge rounded-pill badge-notification bg-danger">{{ count($orders)+count($packing)+count($tracking) }}</span>
                            </a>
                            <ul
                              class="dropdown-menu dropdown-menu-end"
                              aria-labelledby="navbarDropdownMenuLink"
                            >
                            @foreach ($orders as $item)
                            <li>
                                <a class="dropdown-item" href="{{ url('pesanan/'.$item->id) }}">{{ 'Pesanan anda dengan kode '.$item->kode.' sudah di confirm' }}</a>
                            </li>
                            @endforeach
                            @foreach ($packing as $item)
                            <li>
                                <a class="dropdown-item" href="{{ url('pesanan/'.$item->id) }}">{{ 'Lihat hasil packingan barang anda' }}</a>
                            </li>
                            @endforeach
                            @foreach ($tracking as $item)
                            <li>
                                <a class="dropdown-item" href="{{ url('pesanan/'.$item->id) }}">{{ 'Barang anda sudah di kirim, berikan penilaian jika sudah sampai' }}</a>
                            </li>
                            @endforeach
                            </ul>
                          </div>
                            <?php
                            $pesanan_utama = App\Models\Pesanan::where('user_id', Auth::user()->id)
                                ->where('status', 0)
                                ->first();
                            if (!empty($pesanan_utama)) {
                                $notif = App\Models\PesananDetail::where('pesanan_id', $pesanan_utama->id)->count();
                            }
                            ?>
                            <a class="text-reset me-4" href="{{ 'checkout' }}">
                                <i class="fas fa-shopping-cart"></i>
                                @if (!empty($notif))
                                    <span
                                        class="badge rounded-pill badge-notification bg-danger">{{ $notif }}</span>
                                @endif
                            </a>
                            <!-- Avatar -->
                            @php 
                            $avatars = App\Models\User::where('id', Auth::user()->id)->first();
                            @endphp
                            <div class="dropdown">
                                <a class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#"
                                    id="navbarDropdownMenuAvatar" role="button" data-mdb-toggle="dropdown"
                                    aria-expanded="false">
                                    @if($avatars->avatar)
                                    <img src="avatar/{{ $avatars->avatar }}" class="rounded-circle"
                                        height="35" alt="avatar/{{ $avatars->avatar }}" loading="lazy" />
                                    @else
                                    <img src="avatar/user.png" class="rounded-circle"
                                        height="35" alt="avatar/user.png" loading="lazy" />
                                    @endif
                                    <strong class="d-none d-sm-block ms-3 text-dark">{{ Auth::user()->name }}</strong>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                                    <li>
                                        <a class="dropdown-item" href="{{ url('profile') }}">My profile</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ url('pesanan') }}">Pesanan</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ url('/history') }}">History Pesanan</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endauth
                    @endif
                </div>
                <!-- Right elements -->
            </div>
            <!-- Container wrapper -->
        </nav>
        <!-- Navbar -->
        <main class="py-4" style="margin-bottom: 50px; margin-top: 60px;">
            @yield('content')
        </main>
    </div>
    @include('sweetalert::alert')
    <hr class="footer-divider" style="border: 3px solid rgb(36, 15, 221)">
<div class="footer-commons">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-4 order-sm-0 order-md-0 dcd-bg-gray py-5">
                <div class="py-lg-5">
                    <img src="img/deba.png" alt="Dicoding Logo" style="max-height: 37px;" width="130" height="95">
                    <p class="mt-3" style="font-size: 15px;">Deba Store<br>
                        Jl. Sisingamangaraja desa No.km.10.5, Huta Paung<br>
                        Kec. Pollung, Kabupaten Humbang Hasundutan, <br>Sumatera Utara 22457</p>
                    <dl>
                        <dd>
                            <a href="https://www.facebook.com/bandrekandaliman" class="social-media-link p-1 p-md-0 mr-2 text-muted" target="_blank" rel="noopener"><svg width="20" height="20" viewBox="0 0 448 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="currentColor" d="M400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h137.25V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.27c-30.81 0-40.42 19.12-40.42 38.73V256h68.78l-11 71.69h-57.78V480H400a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48z"></path>
                                </svg></a>
                                                            <a href="https://www.instagram.com/bandrek_andaliman/?hl=id" class="social-media-link p-1 p-md-0 mr-2 text-muted" target="_blank" rel="noopener"><svg width="20" height="20" viewBox="0 0 448 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path>
                                </svg></a>
                                </a>
                                                            <a href="https://www.youtube.com/watch?v=yUGt1u5MIqU&list=PLB6B1Nm3HGWJ_yTZTZZA9NpAFmKFsaK27" class="social-media-link p-1 p-md-0 mr-2 text-muted" target="_blank" rel="noopener"><svg width="20" height="20" viewBox="0 0 576 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="currentColor" d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"></path>
                                </svg>
                            </a>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="col-sm-12 col-md-8 order-sm-2 order-md-1 bg-white py-5">
                <div class="row justify-content-end py-lg-5">
                    <div class="col-md-3 col-sm-6 mt-3 mt-md-0">
                        <dl>
                            <dd><a class="d-inline-block py-2 py-md-1" href="{{ url('/hubungi-kami') }}">Hubungi Kami</a></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="dcd-bg-gray border-top">
    <div class="container">
        <div class="row py-3">
            <div class="text-muted">
                &copy; 2022 Debastore
                <span class="">|</span>
                Debastore adalah toko yang memproduksi makanan dan minuman khas Batak.
            </div>
        </div>
    </div>
</footer>
    @yield('script')
    <script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
    </body>
    <script>
        $(document).on('change', '.file-input', function() {
        <!-- Copyright -->
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.js"
        integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
        
</body>
<script>
    $(document).on('change', '.file-input', function() {


        var filesCount = $(this)[0].files.length;

        var textbox = $(this).prev();

        if (filesCount === 1) {
            var fileName = $(this).val().split('\\').pop();
            textbox.text(fileName);
        } else {
            textbox.text(filesCount + ' files selected');
        }
    });
</script>

</html>
