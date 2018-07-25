@extends('layouts.default')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="custom-panel">
            <div class="custom-panel-heading">User #{{ $user->name }}</div>
            {!! Form::model($user, ['method' => 'PUT', 'route' => ['users.update', $user->id], 'class' => 'form-horizontal']) !!}

                @include('Users::users._form', ['submitName' => 'Update'])

            {!! Form::close() !!}
        </div>
    </div>
</div>

@stop