@extends('layouts.default')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="custom-panel">
            <div class="custom-panel-heading">{{ $client->name }}</div>
            {!! Form::model($client, ['method' => 'PUT', 'route' => ['clients.update', $client->id], 'class' => 'form-horizontal']) !!}

                @include('Clients::clients._form', ['submitName' => 'Update'])

            {!! Form::close() !!}
        </div>
    </div>
</div>

@stop