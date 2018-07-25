@include('errors._form-errors')

<div class="form-group">
    {!! Form::label('name', 'Name:', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('description', 'Description:', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('client_id', 'Client:', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::select('client_id', ['Select One'] + $clients, null, ['class' => 'form-control']) !!}
        <label>No clients? <a href="{{ route('clients.create') }}">Go add one.</a></label>
    </div>
</div>

<hr>

<div class="form-group">
    <div class="col-sm-6 col-sm-offset-3">
        <a href="{{ route('projects.index') }}" class="btn btn-default">Back to list</a>
        {!! Form::submit($submitName, ['class' => 'btn btn-primary']) !!}
    </div>
</div>