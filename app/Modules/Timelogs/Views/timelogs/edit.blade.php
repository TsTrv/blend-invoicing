@extends('layouts.default')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="custom-panel">
            <div class="custom-panel-heading">Time log #{{ $timelog->id }}</div>
            {!! Form::model($timelog, ['method' => 'PUT', 'route' => ['timelogs.update', $timelog->id], 'class' => 'form-horizontal']) !!}

                @include('Timelogs::timelogs._form', ['submitName' => 'Update'])

            {!! Form::close() !!}
        </div>
    </div>
</div>

@stop