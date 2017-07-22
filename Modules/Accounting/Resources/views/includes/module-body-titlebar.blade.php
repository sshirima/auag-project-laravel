<ul class="nav nav-pills">
  <li class="nav-item {{ Request::is('accounting/accounts/shares') ? 'active' : '' }}">
    <a class="nav-link" href="{{route('shares')}}">Shares</a>
  </li>
  <li class="nav-item {{ Request::is('accounting/accounts/loans') ? 'active' : '' }}">
    <a class="nav-link" href="{{route('loans')}}">Loans</a>
  </li>
  <li class="nav-item {{ Request::is('accounting/accounts/fines') ? 'active' : '' }}">
    <a class="nav-link" href="{{route('fines')}}">Fines</a>
  </li>
</ul>

