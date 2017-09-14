<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Twig Login</title>
		
		<link rel="stylesheet" type="text/css" href="/css/login.css">
    </head>
    <body>
		<div id="particles-js"></div>
		
		<div class="hero">
			<div class="logo">
        		<h1>TWIT</h1>
				<p>A Simple Twitter Client</p>
			</div>
			
			<div class="wrap">
			  <a class="button rollover" href="{{ route('auth.redirect') }}">
			    <span class="roll-text">Sign In</span>
			    <span class="roll-text"><img src="/img/twitter.svg" alt="Twitter"></span>
			  </a>
			</div>
		</div>

        <script src="/js/particles.js"></script>
    </body>
</html>
