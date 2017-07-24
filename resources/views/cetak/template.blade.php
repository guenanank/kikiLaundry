
<html>
    <head>
        <title>Kiki Laundry :: @yield('title')</title>
        <style type="text/css">
        	hr { border-top: 3px double #8c8b8b }
        	.text-center { text-align: center }
          .text-left { text-align: left }
          .text-right { text-align: right }
        	.pull-right { float: right !important }
        	.pull-left { float: left !important }

            table {
                border-collapse: collapse;
                border-spacing: 0;
            }
        </style>
    </head>
    <body>
        <table width="100%">
            <tr>
                <td>
                    <strong>Kiki Laundry</strong><br />
                    Jl. Persatuan RT 001/07 No 7B Sukabumi Selatan<br />
                    Kebon Jeruk Jakarta Barat 11560<br />
                    Telp: 082211169756
                </td>
                <td>

                </td>
                <td>
                    <div class="pull-right">
                        <!-- <label>Jakarta, {{ date('d F Y') }}</label><br /> -->
                        @stack('customer')
                    </div>
                </td>
            </tr>
        </table>
		<hr />
		<h4 class="text-center">@yield('name')</h4>

        @yield('content')

        <div class="">&nbsp;</div>
        <div class="">&nbsp;</div>
        @stack('footer')
    </body>
</html>
