<ul class="nav nav-pills nav-stacked">
    <li role="presentation" class="{{ Request::is('dashboard') ? 'active' : ''|| Request::is('device-settings') ? 'active' : ''|| Request::is('/') ? 'active' : '' }}" ><a href="dashboard">Dashboard</a></li>
    <li class="nav-divider"></li>
    <li role="presentation" class="{{ Request::is('members') ? 'active' : ''|| Request::is('members-import') ? 'active' : ''  }}"><a href="members">Members</a></li>
    <li class="nav-divider"></li>
    <li role="presentation"class="{{ Request::is('commands') ? 'active' : ''|| Request::is('command-actions') ? 'active' : ''  }}"><a href="commands">Commands</a></li>
    <li class="nav-divider"></li>
    <li role="presentation"class="{{ Request::is('report') ? 'active' : ''|| Request::is('report-SMSinbox') ? 'active' : ''|| Request::is('report-SMSsent') ? 'active' : ''|| Request::is('report-SMSoutbox') ? 'active' : ''}}"><a href="report">Reports</a></li>
</ul>