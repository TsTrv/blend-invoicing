<?php

namespace App\Modules\Quotes\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Quotes\Requests\QuoteRequest;
use App\Modules\Quotes\Repositories\Interfaces\QuoteRepositoryInterface;
use App\Modules\Quotes\Repositories\Interfaces\QuoteItemRepositoryInterface;
use App\Modules\Taxes\Repositories\Interfaces\TaxRepositoryInterface;
use App\Modules\Currencies\Repositories\Interfaces\CurrencyRepositoryInterface;
use Datatables;
use Response;
use Illuminate\Support\Facades\Input;
use App\Base\PDF\domPDF;

class QuotesController extends Controller
{

    /**
     * QuoteRepositoryInterface
     * 
     * @var App\Modules\Quotes\Repositories\Interfaces\QuoteRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * QuoteItemRepositoryInterface
     * 
     * @var App\Modules\Quotes\Repositories\Interfaces\QuoteItemRepositoryInterface
     */
    protected $quoteItemRepository;

    /**
     * TaxRepositoryInterface
     * 
     * @var App\Modules\Taxes\Repositories\Interfaces\TaxRepositoryInterface
     */
    protected $taxRepository;

    /**
     * CurrencyRepositoryInterface
     * 
     * @var App\Modules\Currencies\Repositories\Interfaces\CurrencyRepositoryInterface
     */
    protected $currencyRepository;

    /**
     * Construct
     * 
     * @param QuoteRepositoryInterface $quoteRepository [description]
     * @param TaxRepositoryInterface $taxRepository [description]
     * @param CurrencyRepositoryInterface $currencyRepository [description]
     * 
     */
    public function __construct(
        QuoteRepositoryInterface $quoteRepository,
        TaxRepositoryInterface $taxRepository,
        CurrencyRepositoryInterface $currencyRepository,
        QuoteItemRepositoryInterface $quoteItemRepository
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->taxRepository = $taxRepository;
        $this->currencyRepository = $currencyRepository;
        $this->quoteItemRepository = $quoteItemRepository;
    }

    /**
     * Index. 
     * 
     * @return view
     */
    public function index()
    {
        return view('Quotes::quotes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Quotes::quotes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuoteRequest $request)
    {
        $inputs = $request->all();

        $quote = $this->quoteRepository->create($inputs);
        
        return Response::json(['id' => $quote->id, 'redirectUrl' => route('quotes.edit', $quote->id)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->flashOnly(['item']);

        $quote = $this->quoteRepository->getById($id);
        $taxes = $this->taxRepository->getForBladeSelect('name', 'id');
        $currencies = $this->currencyRepository->getForBladeSelect('code', 'code');

        return view('Quotes::quotes.edit', compact('quote', 'taxes', 'currencies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Modules\Clients\Requests\QuoteRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuoteRequest $request, $id)
    {
        if (!$invoice = $this->quoteRepository->getById($id)) {
            // Abort
        }

        $inputs = request()->all();
        $quote = $this->quoteRepository->update($id, $inputs);

        return Response::json(['id' => $quote->id, 'redirectUrl' => route('quotes.edit', $quote->id)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$quote = $this->quoteRepository->getById($id)) {
            // Abort
        }

        $this->quoteRepository->delete($id);

        return redirect(route('quotes.index'));
    }

    /**
     * Delete Quote Item
     * 
     * @param  [type] $id [description]
     * 
     * @return [type]     [description]
     */
    public function deleteItem($id)
    {
        if ($item = $this->quoteItemRepository->getById($id)) {
            $this->quoteRepository->deleteItem($id);
            return redirect(route('quotes.edit', $item->quote_id));
        }
    }

    /**
     * Datatable
     * 
     * @return json
     */
    public function datatable(Request $request)
    {
        $filter = [];

        $inputs = $request->input();

        if (isset($inputs['client_id'])) {
            $filter = [[
                'key' => 'client_id',
                'value' => $inputs['client_id'],
                'operator' => '='
            ]];
        }

        return Datatables::of($this->quoteRepository->datatableCollection(
                $filter,
                [ 'id', 'number', 'issued_date', 'due_date', 'client_id', 'total', 'total', 'status_id', 'id']))
                ->editColumn('number', function ($row) {
                    return '<a href="'.route('quotes.edit', $row->id).'">#'.$row->number.'</a>';
                })
                ->editColumn('issued_date', function ($row) {
                    return $row->issued_date_formatted;
                })
                ->editColumn('due_date', function ($row) {
                    return $row->issued_date_formatted;
                })
                ->editColumn('client_id', function ($row) {
                    return '<a href="'.route('clients.edit', $row->client_id).'">'.$row->client->name.'</a>';
                })
                ->editColumn('balance', function ($row) {
                    return $row->balance_formatted;
                })
                ->editColumn('total', function ($row) {
                    return $row->total_formatted;
                })
                ->editColumn('status_id', function ($row) {
                    return sprintf('<span class="label label-%s">%s</span>', $row->status_label, $row->status_label);
                })
                ->addColumn('actions', function ($row) {
                    return view('includes._datatable_actions', ['fields' => [
                        'edit' => [
                            'label' => 'Edit',
                            'url' => route('quotes.edit', $row->id),
                            'class' => '',
                            'icon' =>'<i class="glyphicon glyphicon-edit"></i>'
                        ],
                        'pdf' => [
                            'label' => 'PDF',
                            'url' => route('quotes.pdf.view', [$row->id, 'download']),
                            'class' => '',
                            'icon' =>'<i class="glyphicon glyphicon-save-file"></i>'
                        ],
                        'delete' => [
                            'label' => 'Delete',
                            'url' => route('quotes.delete', $row->id),
                            'class' => '',
                            'icon' =>'<i class="glyphicon glyphicon-trash"></i>',
                            'onclick' => "return confirm('If you delete this client you will also delete any invoices, quotes and payments related to this client. Are you sure you want to permanently delete this client?')"
                        ]
                    ]])->render();
                })
                ->removeColumn('id')
            ->make();
    }

    /**
     * PDF 
     * 
     * @param  [type] $invoiceId [description]
     * 
     * @return [type]            [description]
     */
    public function pdf($invoiceId, $mode)
    {
        $quote = $this->quoteRepository->getById($invoiceId);

        $pdf = new domPDF();

        $template = view('Quotes::quotes.templates.default')->with('quote', $quote)->with('logo', url(config('blend.logo')))->render();

        switch ($mode) {
            case 'view':
                $pdf->stream($template, $quote->number.'.pdf');
                break;
    
            case 'download':
                $pdf->download($template, $quote->number.'.pdf');
                break;
        }
    }
}
