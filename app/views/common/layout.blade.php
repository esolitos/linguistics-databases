<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
	
  <link rel="stylesheet" href="{{ asset("css/app.css") }}" />
  <link rel="stylesheet" href="{{ asset("css/foundation-icons/foundation-icons.css") }}" />

  <script type="text/javascript" src="{{ asset("javascript/linguistics-db.js") }}"></script>
  <script type="text/javascript" src="{{ asset("javascript/app.js") }}"></script>

  @if( !empty($extra_scripts) )
    @foreach($extra_scripts as $item)
      <script type="{{ $item->type }}" src="{{ $item->src }}"></script>
    @endforeach
  @endif
  
  <title>Linguistic Database</title>
</head>
<body {{ HTML::attributes($body_attributes) }}>
  <div id="page-wrapper" class="page">
    @if ( Auth::check() )
      @include("common.header")
    @else
      @include("common.simple-header")
    @endif
    <div class="content-wrapper row">
      <div class="container">
      	<h2>Double Object Database</h2>
        <p class="short-description">Database of duble object structures in Croatian</p>       
        @if ( $messages->has('general') )
          <div class="small-10 small-centered columns messages">
            @foreach ($messages->get('general') as $error)
              <div data-alert class="alert-box">
                {{ $error }}
                <a href="#" class="close">&times;</a>
              </div>
            @endforeach
          </div>
        @endif
        <div class="small-12 main-content">
          @yield("content")
        </div>
      </div>
    </div>
    @if ( Auth::check() )
      @include("common.footer")
    @else
      @include("common.simple-footer")
    @endif
  </div>
</body>
</html>