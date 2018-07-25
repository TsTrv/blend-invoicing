<nav class="navbar navbar-default">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <a class="navbar-brand" href="{{ url('/') }}">
          {{ config('app.name', 'Laravel') }}
      </a>
    </div>

    @if($user)

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="{{ $current == 'dashboard' ? 'active' : '' }}">
          <a href="{{  route('dashboard.index') }}">Dashboard</a>
        </li>
        <li class="{{ $current == 'timelogs' ? 'active' : '' }}">
          <a href="{{ route('timelogs.index') }}">Time Logs</a>
        </li>
        <li class="{{ $current == 'clients' ? 'active' : '' }}">
          <a href="{{ route('clients.index') }}">Clients </a>
        </li>
        <li class="{{ $current == 'invoices' ? 'active' : '' }}">
          <a href="{{ route('invoices.index') }}">Invoices</a>
        </li>
        <li class="{{ $current == 'quotes' ? 'active' : '' }}">
          <a href="{{ route('quotes.index') }}">Quotes</a>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Settings <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('projects.index') }}">Projects</a></li>
            <li><a href="{{ route('employees.index') }}">Employees</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="{{ route('taxes.index') }}">Taxes</a></li>
            <li><a href="{{ route('currencies.index') }}">Currencies</a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $user->name }} <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li>
              <a href="{{ route('users.edit', [$user->id]) }}">Account</a>
            </li>
            <li class="devider"></li>
            <li>
              <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
                Log out
              </a>
              <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
              </form>
            </li>
            
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
    @endif

  </div><!-- /.container-fluid -->
</nav>