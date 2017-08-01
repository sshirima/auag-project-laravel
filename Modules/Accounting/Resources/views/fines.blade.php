@extends('accounting::layouts.master-accounting')
@section('title')
Member fines
@endsection

@section('module-body')
@include('accounting::includes.module-body-titlebar')
<br>
<div  class="theme-light">
    <div id="filterbox">
        Search:
        <input type="text" />
        <a><img src="" /></a>
    </div>
    <br>
    <div id="rw_table" ></div>
</div>
<br>
<div class="container">

    <div class="row justify-content-md-center">
        <div class="col col-md-6">
            <fieldset >
                <legend >Fine descriptions</legend>
                <table class="table">
                    <thead >
                        <tr >
                            <th >Fine description</th>
                            <th >Amount</th>
                        </tr>
                    </thead>
                    <tbody >
                        @foreach ($fine_descriptions as $desc)
                        <tr >
                            <td>
                                {{ $desc->finedesc_desc }}
                            </td>
                            <td>
                                {{ $desc->finedesc_amount }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </fieldset>
        </div>
    </div>
</div>

<script>
    var token = '{{ Session::token()}}';
    var urlTableRead = '{{ route('getAllFines')}}';
    var urlTableAdd = '{{ route('addFine')}}';
    var urlTableUpdate = '{{ route('updateFine')}}';
    var urlTableDelete = '{{ route('deleteFine')}}';
    var accounts = '{{ $accounts }}';
    var descriptions = '{{ $fine_descriptions }}';
</script>
<!-- Read and Write table scr        ipt -->
<script type="text/javascript" src="{{ URL::asset('js/table-read-write.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/accounting-fines.js') }}"></script>
@stop

