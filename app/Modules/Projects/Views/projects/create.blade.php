@extends('layouts.default')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="custom-panel">
            <div class="custom-panel-heading">Project Form</div>
            {!! Form::open(['route' => 'projects.store', 'class' => 'form-horizontal']) !!}

                @include('Projects::projects._form', ['submitName' => 'Create'])

            {!! Form::close() !!}
        </div>
    </div>
</div>

@stop
