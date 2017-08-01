@extends('accounting::layouts.master-accounting')
@section('title')
Members
@endsection

@section('module-body')
<div class="row">
    <div class="col col-md-6">
        {{$group}}
        @section('legend_title')
        Group information
        @endsection

        @section('fieldset_body')
        
        <ul class="list-group">
            <li class="list-group-item">
                <b> Group name:</b>{{$group->group_name}}
                <span class="btn badge badge-default badge-pill">Change</span>
            </li>
            
            <br>
            @if ($group->groupsh_price > 0)
            <li class="list-group-item list-group-item-success">
                <b>Price of share unit:</b>{{$group->groupsh_price}}
                <span class="btn badge badge-default badge-pill">Change</span>
            </li>
            @else
            <li class="list-group-item list-group-item-danger">
                <b>Price of share unit:</b>{{$group->groupsh_price}}
                <span class="btn badge badge-default badge-pill">Change</span>
            </li>
            @endif
            <br>
            @if ($group->groupsh_max > 0)
            <li class="list-group-item list-group-item-success">
                <b>Maximum unit purchase:</b>{{$group->groupsh_max}}
                <span class="btn badge badge-default badge-pill">Change</span>
            </li>
            @else
            <li class="list-group-item list-group-item-danger">
                <b>Maximum unit purchase:</b>{{$group->groupsh_max}}
                <span class="btn badge badge-default badge-pill">Change</span>
            </li>
            @endif
            <br>
            @if ($group->groupsh_duration > 0)
            <li class="list-group-item list-group-item-success">
                <b> Circulation duration:</b>{{$group->groupsh_duration}}
                <span class="btn badge badge-default badge-pill">Change</span>
            </li>
            @else
            <li class="list-group-item list-group-item-danger">
                <b> Circulation duration:</b>{{$group->groupsh_duration}}
                <span class="btn badge badge-default badge-pill">Change</span>
            </li>
            @endif
            <br>
            @if ($group->groupln_rate > 0)
            <li class="list-group-item list-group-item-success">
                <b> Current loan rate:</b>{{$group->groupln_rate}}
                <span class="btn btn-default badge" id="sp_rate">Change</span>
            </li>
            @else
            <li class="list-group-item list-group-item-danger">
                <b> Current loan rate: </b>
                <span id="sp_value">{{$group->groupln_rate}}</span>
                <span class="btn btn-default badge" id="change_rate">
                    Change
                </span>
            </li>
            @endif
            
        </ul>
        @endsection
        @include('accounting::includes.fieldset-box')
    </div>
    <div class="col col-md-6">

    </div>
</div>





<br>
<div  class="theme-light">
    <div id="filterbox">
        Search:
        <input type="text" />
        <a><img src="" /></a>
    </div>
    <br>
    <div id="table-read-write" ></div>
</div>

<script>
    var token = '{{ Session::token()}}';
    var urlTableRead = '{{ route('getAllMembers')}}';
    var urlTableAdd = '{{ route('addMember')}}';
    var urlTableUpdate = '{{ route('updateMember')}}';
    var urlTableDelete = '{{ route('deleteMember')}}';
    var url_group_update = '{{ route('updateGroup')}}';
    var group = '{{ $group }}';
</script>
<!-- Read and Write table script -->
<script type="text/javascript" src="{{ URL::asset('js/table-read-write.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/accounting-members.js') }}"></script>

@endsection

