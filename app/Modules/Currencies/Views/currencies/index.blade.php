@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="custom-panel">
                <div class="custom-panel-heading">Currencies</div>
                
                @include('Currencies::currencies._table')

            </div>
        </div>
    </div>

@stop