@extends('layouts.default')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="custom-panel">
            <div class="custom-panel-heading">Time Log Form</div>
            {!! Form::open(['route' => 'timelogs.store', 'class' => 'form-horizontal']) !!}

                @include('Timelogs::timelogs._form', ['submitName' => 'Create'])

            {!! Form::close() !!}
        </div>
    </div>
</div>

@stop
