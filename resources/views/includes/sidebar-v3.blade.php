<ul class="nav nav-pills nav-stacked">
    <li role="presentation" class="{{ Request::is('accounting*') ? 'active' : '' }}" ><a href="{{ route('accounting') }}">Accounting</a></li>
    <li class="nav-divider"></li>
    <li role="presentation" class="{{ Request::is('smsmodule*') ? 'active' : '' }}"><a href="{{ route('smsmodule') }}">SMS service</a></li>
    <li class="nav-divider"></li>
    <li role="presentation"class="{{ Request::is('admin*') ? 'active' : '' }}"><a href="{{ route('admin') }}">Admin</a></li>
</ul>