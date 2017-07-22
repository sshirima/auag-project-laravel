<ul class="nav nav-pills">
  <li class="nav-item {{ Request::is('accounting/transactions/shareoffers') ? 'active' : '' }}">
    <a class="nav-link" href="{{route('shareoffers')}}">Buying shares</a>
  </li>
  <li class="nav-item {{ Request::is('accounting/transactions/sharebids') ? 'active' : '' }}">
    <a class="nav-link" href="{{route('sharebids')}}">Selling shares</a>
  </li>
  <li class="nav-item {{ Request::is('accounting/transactions/loanpayments') ? 'active' : '' }}">
    <a class="nav-link" href="{{route('loanpayments')}}">Loan payments</a>
  </li>
  <li class="nav-item {{ Request::is('accounting/transactions/finepayments') ? 'active' : '' }}">
    <a class="nav-link" href="{{route('finepayments')}}">Fine payments</a>
  </li>
</ul>

