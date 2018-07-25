@extends('layouts.default')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="custom-panel">
            <div class="custom-panel-heading">Client Form</div>
            {!! Form::open(['route' => 'clients.store', 'class' => 'form-horizontal']) !!}

                @include('Clients::clients._form', ['submitName' => 'Create'])

            {!! Form::close() !!}
        </div>
    </div>
</div>

@stop
