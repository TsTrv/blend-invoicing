@extends('layouts.default')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="custom-panel">
            <div class="custom-panel-heading">{{ $project->name }}</div>
            {!! Form::model($project, ['method' => 'PUT', 'route' => ['projects.update', $project->id], 'class' => 'form-horizontal']) !!}

                @include('Projects::projects._form', ['submitName' => 'Update'])

            {!! Form::close() !!}
        </div>
    </div>
</div>

@stop