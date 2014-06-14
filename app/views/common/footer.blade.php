@section("footer")
  <div class="footer">
    <div class="container">
      <div style="text-align:right; margin:25px 10px;">
        <small>Powered by <a href="http://laravel.com">Laravel</a></small>
      </div>
    </div>
  </div>

  <div class="hide scripts">
    @if( App::environment('local') )

        <script type="text/javascript" src="{{ asset("javascript/linguistics-db.js") }}"></script>
        <script type="text/javascript" src="{{ asset("javascript/app.js") }}"></script>
    @else

        <script type="text/javascript" src="{{ asset("javascript/linguistics-db.min.js") }}"></script>
        <script type="text/javascript" src="{{ asset("javascript/app.min.js") }}"></script>        
    @endif
    
    @if( !empty($extra_scripts) )
      @foreach($extra_scripts as $src)
        <script type="text/javascript" src="{{ $src }}"></script>
      @endforeach
    @endif
  </div>

  <div class="hide style">
    <link rel="stylesheet" href="{{ asset("css/foundation-icons/foundation-icons.css") }}" />

    @if( !empty($extra_style) )
      @foreach($extra_style as $src)
        <link rel="stylesheet" href="{{ $src }}" type="text/css" media="all">
      @endforeach
    @endif
  </div>
  
  </div>
</body>
</html>
  
@show