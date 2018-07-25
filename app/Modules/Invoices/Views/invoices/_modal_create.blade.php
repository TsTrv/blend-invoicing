<div class="modal fade" id="create-invoice">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Create Invoice</h4>
            </div>
        
            <div class="modal-body">

                {!! Form::open(['route' => 'invoices.store', 'class' => 'form-horizontal', 'id'=>'create-invoice-form']) !!}

                <div class="form-group">
                    <label class="col-sm-3 control-label">Client</label>

                    <div class="col-sm-9">
                        {!! Form::select('client_id', [], null,['id' => 'create_client_name', 'class' =>
                        'form-control client-lookup', 'autocomplete' => 'off']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Invoice Date</label>

                    <div class="col-sm-9">
                        {!!  Form::text('issued_date', date(config('blend.dateFormat')), ['id' =>
                        'create_issued_date', 'class' => 'form-control custom-date' ]) !!}
                    </div>
                </div>

                @include('errors._ajax-form-errors', ['id' => 'create-invoice-error-response'])

                {!! Form::close() !!}

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                {!! Form::submit('Submit', ['class' => 'btn btn-primary', 'id'=>'create-invoice-submit']) !!}
            </div>

        </div>
    </div>
</div>

@include('Invoices::invoices._js_client_lookup',['element' => '#create_client_name'])

@section('js')
    @parent
    <script type="text/javascript">

    $('#create_issued_date').datepicker({format: '{{ config('blend.datepicker') }}', autoclose: true});

    $('body').on('click', '.create-invoice-trigger', function(){
        $('#create-invoice').modal('show');
    });

    $('body').on('click', '#create-invoice-submit', function(){

        var form = $('#create-invoice-form');

        $.ajax({
            type: 'post',
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'json',
            success: function(data){
                window.location = data.redirectUrl;
            },
            error: function(data){
                var responseString = '';
                var errors = data.responseJSON;

                $.each(errors, function(index, value) {
                    responseString += value.join('<br/>');
                });

                $('#create-invoice-error-response').html(responseString);
                $('.ajax-error').show();

          }
        });
    });
    </script>
@endsection