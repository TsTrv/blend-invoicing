@include('errors._form-errors')

<div class="row">
    <div class="col-sm-4">

        <div class="panel panel-default">
            <div class="panel-heading">{{ $invoice->client->name }}</div>
            <div class="panel-body">
                <div class="location">
                    {!! $invoice->client->address_formatted !!}
                </div>
                <div class="contact">
                    <span><b>Email: </b>{!! $invoice->client->email !!}</span>
                    <span><b>Phone: </b>{!! $invoice->client->phone !!}</span>
                </div>
            </div>
        </div>

    </div>

    <div class="col-sm-5 col-sm-offset-3 invoice-details">
        <div class="panel panel-default">
            <div class="panel-body">

                {!! Form::hidden('client_id', null) !!}

                <div class="form-group">
                    {!! Form::label('number', 'Invoice #:', ['class' => 'col-sm-6']) !!}
                    <div class="col-sm-6">
                        {!! Form::text('number', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                
                <div class="form-group">
                    {!! Form::label('issued_date', 'Date:', ['class' => 'col-sm-6']) !!}
                    <div class="col-sm-6">
                        {!! Form::text('issued_date', $invoice->issued_date_formatted, ['class' => 'form-control']) !!}
                    </div>
                </div>
                
                <div class="form-group">
                    {!! Form::label('due_date', 'Due Date:', ['class' => 'col-sm-6']) !!}
                    <div class="col-sm-6">
                        {!! Form::text('due_date', $invoice->due_date_formatted, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('status_id', 'Status:', ['class' => 'col-sm-6']) !!}
                    <div class="col-sm-6">
                        {!! Form::select('status_id', $invoice->statuses(), $invoice->status_id, ['class' => 'form-control input-sm']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('currency_code', 'Currency:', ['class' => 'col-sm-6']) !!}
                    <div class="col-sm-6">
                        {!! Form::select('currency_code', $currencies, null, ['class' => 'form-control']) !!}
                    </div>
                </div>

            </div>
        </div>
        
    </div>
</div>

<div class="row">   
    
    <a class="btn pull-right" id="btn-add-item">
        <i class="glyphicon glyphicon-plus"></i> Add Item
    </a>

    <table class="table table-hover" id="item-table">
        <thead>
            <tr>
                <th style="width: 20%">Product</th>
                <th style="width: 25%">Description</th>
                <th style="width: 10%">Qty</th>
                <th style="width: 10%">Price</th>
                <th style="width: 10%">Tax Rate</th>
                <th style="width: 10%">Subtotal</th>
                <th style="width: 10%">Total</th>
                <th style="width: 5%"></th>
            </tr>
        </thead>
        <tbody>

            <tr id="new-item" style="display:none">
                <td>
                    {!! Form::hidden('item[id][]', null) !!}
                    {!! Form::text('item[name][]', null, ['class' => 'form-control']) !!}
                </td>
                <td>
                    {!! Form::textarea('item[description][]', null, ['class' => 'form-control', 'rows' => 1]) !!}
                </td>
                <td>
                    {!! Form::text('item[quantity][]', null, ['class' => 'form-control']) !!}
                </td>
                <td>
                    {!! Form::text('item[price][]', null, ['class' => 'form-control']) !!}
                </td>
                <td>
                    {!! Form::select('item[tax_rate_id][]', $taxes, null, ['class' => 'form-control']) !!}
                </td>
                <td></td>
                <td></td>
                <td>
                    <a href="javascript:void(0)" class="tr-remove">
                        <i class="glyphicon glyphicon-remove"></i>
                    </a>
                </td>
            </tr>

            @if($invoice->items->count())
                @foreach ($invoice->items as $item)
                    <tr class="item" id="tr-item-{{ $item->id }}">
                        <td>
                            {!! Form::hidden('item[id][]', $item->id) !!}
                            {!! Form::text('item[name][]', $item->name, ['class' => 'form-control']) !!}
                        </td>
                        <td>
                            {!! Form::textarea('item[description][]', $item->description, ['class' => 'form-control', 'rows' => 1]) !!}
                        </td>
                        <td>
                            {!! Form::text('item[quantity][]', $item->formatted_quantity, ['class' => 'form-control']) !!}
                        </td>
                        <td>
                            {!! Form::text('item[price][]', $item->formatted_numeric_price, ['class' => 'form-control']) !!}
                        </td>
                        <td>
                            {!! Form::select('item[tax_rate_id][]', $taxes, $item->tax_rate_id, ['class' => 'form-control']) !!}
                        </td>
                        <td>{!! $item->formatted_subtotal !!}</td>
                        <td>{!! $item->formatted_total !!}</td>
                        <td>
                            <a href="{!! route('invoices.item.delete', $item->id) !!}" onclick="return confirm('Are you sure you wish to delete this record?')">
                                <i class="glyphicon glyphicon-remove"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
        
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5"></td>
                <td><b>Subtotal</b></td>
                <td>{!! $invoice->subtotal_formatted !!}</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5"></td>
                <td><b>Invoice Tax</b></td>
                <td>{!! $invoice->tax_formatted !!}</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5"></td>
                <td><b>Total</b></td>
                <td>{!! $invoice->total_formatted !!}</td>
                <td></td>
            </tr>
        <tfoot>
    </table>

<div class="row clearfix">   
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::label('terms', 'Terms:', ['class' => 'col-sm-12', 'style' => 'text-align:left']) !!}
            <div class="col-sm-12">
                {!! Form::textarea('terms', null, ['class' => 'form-control', 'rows' => 4]) !!}
            </div>
        </div>

        @include('errors._ajax-form-errors', ['id'=>'update-invoice-error-response'])

    </div>
</div>
<hr/>
<div class="form-group">
    <div class="col-sm-3 col-sm-offset-9">

        <a href="{{ route('invoices.index') }}" class="btn btn-default">Back to list</a>
        <a href="javascript:void(0)" class="btn btn-default btn-primary submit-invoice">Create</a>

    </div>
</div>

@section('js')
<script type="text/javascript">

$('#issued_date').datepicker({format: '{{ config('blend.datepicker') }}', autoclose: true});
$('#due_date').datepicker({format: '{{ config('blend.datepicker') }}', autoclose: true});

$('body').on('click', '.submit-invoice', function(e) {

    $('.ajax-error').hide();

    var form = $('.update-invoice-form');

    $('#new-item').find('input').prop('disabled', true);
    $('#new-item').find('textarea').prop('disabled', true);
    $('#new-item').find('select').prop('disabled', true);

    $.ajax({
        type: 'post',
        url: form.attr('action'),
        data: form.serialize(),
        dataType: 'json',
        success: function(data){
            console.log(data);
            window.location = data.redirectUrl;
        },
        error: function(data){

            var responseString = '';
            var errors = data.responseJSON;

            $.each(errors, function(index, value) {
                responseString += value.join('<br/>')+'<br/>';
            });

            $('#update-invoice-error-response').html(responseString);
            $('.ajax-error').show();
        }
    });
});

function cloneItemRow() {
    $('#new-item').find('input').prop('disabled', false);
    $('#new-item').find('textarea').prop('disabled', false);
    $('#new-item').find('select').prop('disabled', false);

    var row = $('#new-item').clone().appendTo('#item-table');
    row.removeAttr('id').addClass('item').show();
}

$(document).on('click', '#btn-add-item', function () {
    cloneItemRow();
});

@if (!$invoice->items->count())
    cloneItemRow();
@endif

$('body').on('click', '.tr-remove', function(){
    var itemId = $(this).data('item-id');

    if(typeof(itemId) === 'undefined'){
        $(this).closest('tr').remove();
    }
})
</script>
@endsection