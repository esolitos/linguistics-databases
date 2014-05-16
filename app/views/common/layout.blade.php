<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="/foundation/stylesheets/app.css" />
	<title>Linguistic Database</title>
</head>
<body {{ HTML::attributes($body_attributes) }}>
	@include("common.header")
	<div class="content">
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
	@include("common.footer")
</body>
</html>