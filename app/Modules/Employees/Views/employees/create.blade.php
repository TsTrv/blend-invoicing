@extends('layouts.default')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="custom-panel">
            <div class="custom-panel-heading">Employee Form</div>
            {!! Form::open(['route' => 'employees.store', 'class' => 'form-horizontal']) !!}

                @include('Employees::employees._form', ['submitName' => 'Create'])

            {!! Form::close() !!}
        </div>
    </div>
</div>

@stop
