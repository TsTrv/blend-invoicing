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
    {!! Form::label('address', 'Address:', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::textarea('address', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('city', 'City:', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('city', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('state', 'State:', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('state', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('postal_code', 'Postal Code:', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('postal_code', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('country', 'Country:', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('country', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('phone', 'Phone Number:', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('phone', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('web', 'Web Address:', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('web', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('active', 'Active:', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::select('active', ['0' => 'No', '1' => 'Yes'], null,['class' => 'form-control']) !!}
    </div>
</div>

<hr>

<div class="form-group">
    <div class="col-sm-6 col-sm-offset-3">
        <a href="{{ route('clients.index') }}" class="btn btn-default">Back to list</a>
        {!! Form::submit($submitName, ['class' => 'btn btn-primary']) !!}
    </div>
</div>