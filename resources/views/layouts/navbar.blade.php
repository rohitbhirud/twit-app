<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">Twig</a>

    <form action="{{ route('logout') }}" method="POST" class="form-inline">
    	{{ csrf_field() }}
    	<button class="nav-link btn btn-danger" type="submit">Logout</button>
  	</form>
  </div>
</nav>