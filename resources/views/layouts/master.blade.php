@include('layouts.header')

<div id="app">
	
	@include('layouts.navbar')
		
	@yield('content')

</div>

	@include('layouts.footer')