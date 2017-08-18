
<html>
    <head>
        <title>Kiki Laundry :: @yield('title')</title>
        <style type="text/css">
          /** { font-size: 110% }*/
          * { margin: 0 }
        	hr { border-top: 3px double #8c8b8b; margin: 0 10px; }
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
      <table width="100%" style="margin: 15px">
        <tr>
          <td>
            <strong>Kiki Laundry</strong><br />
            Jl. Persatuan RT 001/07 No 7B Sukabumi Selatan<br />
            Kebon Jeruk Jakarta Barat 11560 Telp: 082211169756
          </td>
          <td>&nbsp;</td>
          <td>
            <div class="pull-right">
              <!-- <label>Jakarta, {{ date('d F Y') }}</label><br /> -->
              @stack('customer')
            </div>
          </td>
        </tr>
      </table>
  		<hr />
      <p class="text-center" style="margin: 10px">@yield('name')</p>
      <div style="margin: 10px 15px">
        @yield('content')
      </div>
      <div class="">&nbsp;</div>
      @stack('footer')
    </body>
</html>
