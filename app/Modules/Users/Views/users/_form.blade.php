@include('errors._form-errors')

<div class="form-group">
    {!! Form::label('user_id', 'Name', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('name', null,['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('user_id', 'Email', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::email('email', null,['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('company', 'Company', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('company', null,['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('address', 'Address', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::textarea('address', null,['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('city', 'City', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('city', null,['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('state', 'State', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('state', null,['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('zip', 'Zip', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('zip', null,['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('country', 'Country', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('country', null,['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('phone', 'Phone', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('phone', null,['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('web', 'Web', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('web', null,['class' => 'form-control']) !!}
    </div>
</div>

<hr>

<div class="form-group">
    <div class="col-sm-6 col-sm-offset-3">
        <a href="{{ route('users.index') }}" class="btn btn-default">Back to list</a>
        {!! Form::submit($submitName, ['class' => 'btn btn-primary']) !!}
    </div>
</div>
