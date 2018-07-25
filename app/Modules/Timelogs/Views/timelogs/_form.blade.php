@include('errors._form-errors')

<div class="form-group">
    {!! Form::label('user_id', 'User', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::select('user_id', $employees, null,['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('project_id', 'Project', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::select('project_id', $projects, null,['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('total', 'Hours', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('total', null,['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('date', 'Date', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('date', @$timelog->date_formatted,['class' => 'form-control', 'id' => 'timelog_date']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('description', 'Description', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::textarea('description', null,['class' => 'form-control']) !!}
    </div>
</div>

<hr>

<div class="form-group">
    <div class="col-sm-6 col-sm-offset-3">
        <a href="{{ route('timelogs.index') }}" class="btn btn-default">Back to list</a>
        {!! Form::submit($submitName, ['class' => 'btn btn-primary']) !!}
    </div>
</div>

@section('js')

<script type="text/javascript">

    $('#timelog_date').datepicker({format: '{{ config('blend.datepicker') }}', autoclose: true});

</script>

@endsection