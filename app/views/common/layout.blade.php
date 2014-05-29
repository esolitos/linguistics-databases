<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	
  <link rel="stylesheet" href="{{ asset("css/app.css") }}" />
  <script type="text/javascript" src="{{ asset("js/vendor/modernizr.js") }}"></script>
  <script type="text/javascript" src="{{ asset("js/vendor/jquery.js") }}"></script>
  <script type="text/javascript" src="{{ asset("js/vendor/fastclick.js") }}"></script>

  <script type="text/javascript" src="{{ asset("js/foundation.min.js") }}"></script>

  <script type="text/javascript" src="{{ asset("foundation/js/app.js") }}"></script>
  
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
  			@if ( $messages->has('general') )
  				<div class="errors">
  					@foreach ($messages->get('general') as $error)
  						<div>{{ $error }}</div>
  					@endforeach
  				</div>
  			@endif
  			@yield("content")
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