@include('errors._form-errors')

<div class="form-group">
    {!! Form::label('name', 'Name:', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('email_addresss', 'Email Address:', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::input('email', 'email', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('roles', 'Roles:', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::select('roles', ['Please select'] + $roles, @$employee->roles_first, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('password', 'Password:', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::password('password', ['class' => 'form-control']) !!}
    </div>
</div>

<hr>

<div class="form-group">
    <div class="col-sm-6 col-sm-offset-3">
        <a href="{{ route('employees.index') }}" class="btn btn-default">Back to list</a>
        {!! Form::submit($submitName, ['class' => 'btn btn-primary']) !!}
    </div>
</div>