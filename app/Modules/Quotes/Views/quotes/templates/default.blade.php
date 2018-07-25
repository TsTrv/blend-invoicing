<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ trans('blend.invoice') }} #{{ $quote->number }}</title>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet" type="text/css">
    <style>
        @page {
            margin: 25px;
        }

        body {
            color: #001028;
            background: #FFFFFF;
            font-family: sans-serif;
            font-size: 12px;
            margin-bottom: 50px;
            font-family: 'Ubuntu', sans-serif;
        }

        a {
            color: #5D6975;
            text-decoration: underline;
        }

        h1 {
            color: #5D6975;
            font-size: 2.8em;
            line-height: 1.4em;
            font-weight: bold;
            margin: 0;
        }

        table {
            width: 100%;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        th {
            padding: 5px 10px;
            color: #5D6975;
            border-bottom: 1px solid #C1CED9;
            white-space: nowrap;
            font-weight: normal;
        }

        td {
            padding: 10px;
        }

        table.alternate tr:nth-child(odd) td {
            background: #F5F5F5;
        }

        th.amount, td.amount {
            text-align: right;
        }

        .info {
            color: #5D6975;
            font-weight: bold;
        }

        .footer {
            position: fixed;
            height: 50px;
            width: 100%;
            bottom: 0px;
            text-align: center;
        }

    </style>
</head>
<body>

<table>
    <tr>
        <td colspan="2">
            <img src="{!! $logo !!}" width="100px" /><br><br>
        </td>
        <td style="width: 30%; text-align: right;" valign="top">
            <h2>{{ config('blend.company') }}</h2>
            {!! implode('<br/>', [
                    config('blend.address'),
                    config('blend.city'),
                    config('blend.postal_code'),
                    config('blend.country'),
                    '<b>Phone:</b> '.config('blend.phone'),
                    '<b>Email:</b>'.config('blend.email')
                ])
            !!}
            <br><br>
        </td>
    </tr>
    <tr>
        <td style="width: 30%;" valign="top">
            <span class="info">{{ mb_strtoupper(trans('blend.issued')) }}:</span> {{ $quote->issued_date_formatted }}<br>
            <span class="info">{{ mb_strtoupper(trans('blend.due_date')) }}:</span> {{ $quote->due_date_formatted }}<br><br>
            <span class="info">{{ mb_strtoupper(trans('blend.bill_to')) }}:</span><br>
            {{ $quote->client->name }}<br>
            @if ($quote->client->address) {!! $quote->client->address_formatted !!}<br>@endif
        </td>
        <td style="width: 40%; text-align: center;" valign="top">
            <h1>{{ mb_strtoupper(trans('blend.quote')) }} #{{ $quote->number }}</h1>
        </td>
    </tr>
</table>

<table class="alternate">
    <thead>
    <tr>
        <th>{{ mb_strtoupper(trans('blend.item')) }}</th>
        <th>{{ mb_strtoupper(trans('blend.description')) }}</th>
        <th class="amount">{{ mb_strtoupper(trans('blend.quantity')) }}</th>
        <th class="amount">{{ mb_strtoupper(trans('blend.price')) }}</th>
        <th class="amount">{{ mb_strtoupper(trans('blend.total')) }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($quote->items as $item)
        <tr>
            <td>{!! $item->name !!}</td>
            <td>{!! $item->formatted_description !!}</td>
            <td nowrap class="amount">{{ $item->formatted_quantity }}</td>
            <td nowrap class="amount">{{ $item->formatted_price }}</td>
            <td nowrap class="amount">{{ $item->formatted_subtotal }}</td>
        </tr>
    @endforeach

    <tr>
        <td colspan="4" class="amount">{{ mb_strtoupper(trans('blend.subtotal')) }}</td>
        <td class="amount">{{ $quote->subtotal_formatted }}</td>
    </tr>

    <tr>
        <td colspan="4" class="amount">Tax</td>
        <td class="amount">{{ $quote->tax_formatted }}</td>
    </tr>

    <tr>
        <td colspan="4" class="amount">{{ mb_strtoupper(trans('blend.total')) }}</td>
        <td class="amount">{{ $quote->total_formatted }}</td>
    </tr>
    </tbody>
</table>

@if ($quote->terms)
    <table style="margin-top: 50px;">
        <tr>
            <th>{{ mb_strtoupper(trans('blend.terms_and_conditions')) }}</th>
        </tr>
        <tr>
            <td>{!! $quote->formatted_terms !!}</td>
        </tr>
    </table>
@endif

<table>
    <tr>
        <td style="width: 60%"></td>
        <td>
            <span style="font-family: 'Indie Flower', cursive; margin-left: 10px; font-size: 18px"></span>
        </td>
    </tr>
    <tr>
        <td></td>
        <td style="border-top: solid 1px #000">Authorized person for signing the quote</td>
    </tr>
</table>

</body>
</html>