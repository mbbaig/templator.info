<!DOCTYPE html>
<html>
	<head>
		<title>Templator</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		{{ HTML::script('js/jquery-1.11.0.min.js') }}
		{{ HTML::script('js/bootstrap.min.js') }}
		{{ HTML::style('css/bootstrap.min.css') }}
		{{ HTML::style('css/bootstrap-theme.min.css') }}
		{{ HTML::style('css/other.css') }}
		<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

	</head>
	<body>
		<div id="wrap">
			<nav class="navbar navbar-inverse" role="navigation">
				<div class="container">
					<div class="navbar-inner navbar-collapse collapse">
						<div class="navbar-header col-xs-2">
							<a class="navbar-brand navbar-left" href="/">Templator</a>
						</div>
						{{ Form::open(array('url' => 'templates/search', 'class' => 'navbar-form navbar-middle', 'role' => 'search')) }}
							<div class="col-xs-8">
								@if(isset($search))
									{{ Form::text('search', $search, array('class'=>'form-control', 'placeholder'=>'Write search term here and press ENTER', 'id' => 'search')) }}
								@else
									{{ Form::text('search', '', array('class'=>'form-control', 'placeholder'=>'Write search term here and press ENTER', 'id' => 'search')) }}
								@endif
							</div>
						{{ Form::close() }}
						@if(Auth::check())
							<a class="btn btn-info navbar-right col-xs-2" href="/users/show/{{ Auth::user()->id }}">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</a>
						@else
							<a class="btn btn-success navbar-right col-xs-2" href="/users/index">Login/Register</a>
						@endif
					</div>
				</div>
			</nav>
			<!-- Content-->
			<div class="mainContent">@yield('content')</div>
			<div id="push"></div>
		</div>
		<div id="footer">
			<div class="container">
				<p class="end">Templator &copy; 2014 - <a href="/faq">FAQ</a> - <a href="/about">About</a></p>
			</div>
		</div>
	</body>
</html>