<!DOCTYPE html>
	<head>
        <base href="{{ url('/') }}" />
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="author" content="nanank" />
        <title>Kiki Laundry :: @yield('title') </title>
        
        {{ Html::style('css/fullcalendar.min.css') }}
        {{ Html::style('css/animate.min.css') }}
        {{ Html::style('css/sweetalert2.min.css') }}
        {{ Html::style('css/material-design-iconic-font.min.css') }}
        {{ Html::style('css/jquery.mCustomScrollbar.min.css') }}
        {{ Html::style('css/bootstrap-select.css') }}
        {{ Html::style('css/nouislider.min.css') }}
        {{ Html::style('css/bootstrap-datetimepicker.min.css') }}

        

        @stack('styles')

        {{ Html::style('css/app_1.min.css') }}
        {{ Html::style('css/app_2.min.css') }}

        <style type="text/css">
            .table tbody > tr > th, .table tbody > tr > td {
                vertical-align: middle;
            }
        </style>
	</head>
	<body>
		<header id="header" class="clearfix" data-ma-theme="blue">
            <ul class="h-inner">
                <li class="hi-trigger ma-trigger" data-ma-action="sidebar-open" data-ma-target="#sidebar">
                    <div class="line-wrap">
                        <div class="line top"></div>
                        <div class="line center"></div>
                        <div class="line bottom"></div>
                    </div>
                </li>

                <li class="hi-logo hidden-xs">
                    {{ link_to('/', 'Kiki Laundry') }}
                </li>

                <li class="pull-right">
                    <ul class="hi-menu">
                        <li data-ma-action="search-open">
                            <a href="#"><i class="him-icon zmdi zmdi-search"></i></a>
                        </li>
                    </ul>
                </li>
            </ul>

            <!-- Top Search Content -->
            <div class="h-search-wrap">
                <div class="hsw-inner">
                    <i class="hsw-close zmdi zmdi-arrow-left" data-ma-action="search-close"></i>
                    <input type="text">
                </div>
            </div>
        </header>

        <section id="main">
            <aside id="sidebar" class="sidebar c-overflow">
                <div class="s-profile">
                    <a href="#" data-ma-action="profile-menu-toggle">
                        <div class="sp-pic">
                            <img src="{{ asset('img/demo/profile-pics/1.jpg') }}" alt="">
                        </div>

                        <div class="sp-info">
                            Malinda Hollaway <i class="zmdi zmdi-caret-down"></i>
                        </div>
                    </a>

                    <ul class="main-menu">
                        <li>
                            <a href="#"><i class="zmdi zmdi-account"></i> View Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="zmdi zmdi-time-restore"></i> Logout</a>
                        </li>
                    </ul>
                </div>

                <ul class="main-menu">
                    <li>
                        <a href="{{ url('/') }}"><i class="zmdi zmdi-home"></i> Beranda</a>
                    </li>
                    <li class="sub-menu">
                        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-layers"></i> Master</a>
                        <ul>
                            <li>{{ link_to('karyawan', 'Karyawan') }}</li>
                            <li>{{ link_to('pelanggan', 'Pelanggan') }}</li>
                            <li>{{ link_to('barang', 'Barang') }}</li>
                            <li>{{ link_to('cuci', 'Cucian') }}</li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ url('order') }}"><i class="zmdi zmdi-collection-text"></i> Order</a>
                    </li>
                    <li class="sub-menu">
                        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-balance-wallet"></i> Administrasi</a>
                        <ul>
                            <li>{{ link_to('pemasukan', 'Pemasukan') }}</li>
                            <li>{{ link_to('pengeluaran', 'Pengeluaran') }}</li>
                            <li>{{ link_to('#', 'Gaji') }}</li>
                        </ul>
                    </li>
                </ul>
            </aside>

            <section id="content">
                <div class="container">
                    @yield('content')
                </div>
            </section>
        </section>

		
		<footer id="footer">
            Copyright &copy; {{ date('Y') }} Kiki Laundry
        </footer>

        <!-- Page Loader -->
        <div class="page-loader">
            <div class="preloader pls-blue">
                <svg class="pl-circular" viewBox="25 25 50 50">
                    <circle class="plc-path" cx="50" cy="50" r="20" />
                </svg>

                <p>Please wait...</p>
            </div>
        </div>

        <!-- Older IE warning message -->
        <!--[if lt IE 9]>
            <div class="ie-warning">
                <h1 class="c-white">Warning!!</h1>
                <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
                <div class="iew-container">
                    <ul class="iew-download">
                        <li>
                            <a href="http://www.google.com/chrome/">
                                <img src="img/browsers/chrome.png" alt="">
                                <div>Chrome</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.mozilla.org/en-US/firefox/new/">
                                <img src="img/browsers/firefox.png" alt="">
                                <div>Firefox</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.opera.com">
                                <img src="img/browsers/opera.png" alt="">
                                <div>Opera</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.apple.com/safari/">
                                <img src="img/browsers/safari.png" alt="">
                                <div>Safari</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                                <img src="img/browsers/ie.png" alt="">
                                <div>IE (New)</div>
                            </a>
                        </li>
                    </ul>
                </div>
                <p>Sorry for the inconvenience!</p>
            </div>
        <![endif]-->

        {{ Html::script('js/jquery.min.js') }}
        {{ Html::script('js/bootstrap.min.js') }}
        {{ Html::script('js/moment.min.js') }}

        {{ Html::script('js/fullcalendar.min.js') }}
        {{ Html::script('js/waves.min.js') }}
        {{ Html::script('js/bootstrap-growl.min.js') }}
        {{ Html::script('js/sweetalert2.min.js') }}
        {{ Html::script('js/jquery.mCustomScrollbar.concat.min.js') }}
        {{ Html::script('js/autosize.min.js') }}

        {{ Html::script('js/bootstrap-select.js') }}
        {{ Html::script('js/nouislider.min.js') }}
        {{ Html::script('js/bootstrap-datetimepicker.min.js') }}
        {{ Html::script('js/typeahead.bundle.min.js') }}
        {{ Html::script('js/jquery.mask.min.js') }}
        {{ Html::script('js/jquery.maskmoney.min.js') }}

        {{ Html::script('js/app.min.js') }}

        <script type="text/javascript">
            var base_url = $('base').attr('href');
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }
                });


            });
        </script>

        {{ Html::script('js/ajax_form.js') }}

        <script type="text/javascript">
            (function ($) {
                $('form.ajax_form').submit(function (e) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    $(this).ajax_form();
                });

                $('a.delete').click(function(e) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    $(this).ajax_delete();
                });

                $('input.money').on('focus', function() {
                    $(this).maskMoney({
                        affixesStay: false,
                        precision: 0
                    });
                });

                $('input.money').on('blur', function() {
                    $(this).maskMoney('destroy');
                });
            })(jQuery);

            var price_format = function(number) {
                var regex = parseFloat(number, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
                return 'Rp. ' + regex.slice(0, -3);
            };
        </script>

        @stack('scripts')

        <script type="text/javascript">
            console.info('Document length: ' + $('*').length);
        </script>
	</body>
</html>