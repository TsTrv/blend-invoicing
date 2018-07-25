@extends('layouts.default')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="custom-panel">
            <div class="custom-panel-heading">{{ $employee->name }}</div>
            {!! Form::model($employee, ['method' => 'PUT', 'route' => ['employees.update', $employee->id], 'class' => 'form-horizontal']) !!}

                @include('Employees::employees._form', ['submitName' => 'Create'])

            {!! Form::close() !!}
        </div>
    </div>
</div>

@stop