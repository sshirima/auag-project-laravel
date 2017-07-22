<li role="presentation" class="{{ Request::is('report') ? 'active' : '' }}"><a href="report">Overall report</a></li>
<li role="presentation" class="{{ Request::is('report-SMSinbox') ? 'active' : '' }}"><a href="report-SMSinbox">Received SMS</a></li>
<li role="presentation" class="{{ Request::is('report-SMSoutbox') ? 'active' : '' }}"><a href="report-SMSoutbox">Outbox SMS</a></li>
<li role="presentation" class="{{ Request::is('report-SMSsent') ? 'active' : '' }}"><a href="report-SMSsent">Sent SMS</a></li>
