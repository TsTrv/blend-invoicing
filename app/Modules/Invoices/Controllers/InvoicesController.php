<?php

namespace App\Modules\Invoices\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Invoices\Requests\InvoiceRequest;
use App\Modules\Invoices\Repositories\Interfaces\InvoiceRepositoryInterface;
use App\Modules\Invoices\Repositories\Interfaces\InvoiceItemRepositoryInterface;
use App\Modules\Taxes\Repositories\Interfaces\TaxRepositoryInterface;
use App\Modules\Currencies\Repositories\Interfaces\CurrencyRepositoryInterface;
use Datatables;
use Response;
use Illuminate\Support\Facades\Input;
use App\Base\PDF\domPDF;

class InvoicesController extends Controller
{

    /**
     * InvoiceRepositoryInterface
     * 
     * @var App\Modules\Invoices\Repositories\Interfaces\InvoiceRepositoryInterface
     */
    protected $invoiceRepository;

    /**
     * InvoiceItemRepositoryInterface
     * 
     * @var App\Modules\Invoices\Repositories\Interfaces\InvoiceItemRepositoryInterface
     */
    protected $invoiceItemRepository;

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
     * @param InvoiceRepositoryInterface $invoiceRepository [description]
     * @param TaxRepositoryInterface $taxRepository [description]
     * @param CurrencyRepositoryInterface $currencyRepository [description]
     * 
     */
    public function __construct(
        InvoiceRepositoryInterface $invoiceRepository,
        TaxRepositoryInterface $taxRepository,
        CurrencyRepositoryInterface $currencyRepository,
        InvoiceItemRepositoryInterface $invoiceItemRepository
    ) {
        $this->invoiceRepository = $invoiceRepository;
        $this->taxRepository = $taxRepository;
        $this->currencyRepository = $currencyRepository;
        $this->invoiceItemRepository = $invoiceItemRepository;
    }

    /**
     * Index. 
     * 
     * @return view
     */
    public function index()
    {
        return view('Invoices::invoices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Invoices::invoices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceRequest $request)
    {
        $inputs = $request->all();

        $invoice = $this->invoiceRepository->create($inputs);
        
        return Response::json(['id' => $invoice->id, 'redirectUrl' => route('invoices.edit', $invoice->id)]);
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

        $invoice = $this->invoiceRepository->getById($id);
        $taxes = $this->taxRepository->getForBladeSelect('name', 'id');
        $currencies = $this->currencyRepository->getForBladeSelect('code', 'code');

        return view('Invoices::invoices.edit', compact('invoice', 'taxes', 'currencies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Modules\Clients\Requests\InvoiceRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InvoiceRequest $request, $id)
    {
        if (!$invoice = $this->invoiceRepository->getById($id)) {
            // Abort
        }

        $inputs = request()->all();
        $invoice = $this->invoiceRepository->update($id, $inputs);

        return Response::json(['id' => $invoice->id, 'redirectUrl' => route('invoices.edit', $invoice->id)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$invoice = $this->invoiceRepository->getById($id)) {
            // Abort
        }

        $this->invoiceRepository->delete($id);

        return redirect(route('invoices.index'));
    }

    /**
     * Delete Invoice Item
     * 
     * @param  [type] $id [description]
     * 
     * @return [type]     [description]
     */
    public function deleteItem($id)
    {
        if ($item = $this->invoiceItemRepository->getById($id)) {
            $this->invoiceRepository->deleteItem($id);
            return redirect(route('invoices.edit', $item->invoice_id));
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

        return Datatables::of($this->invoiceRepository->datatableCollection(
                $filter,
                [ 'id', 'number', 'issued_date', 'due_date', 'client_id', 'total', 'total', 'status_id', 'id']))
                ->editColumn('number', function ($row) {
                    return '<a href="'.route('invoices.edit', $row->id).'">#'.$row->number.'</a>';
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
                            'url' => route('invoices.edit', $row->id),
                            'class' => '',
                            'icon' =>'<i class="glyphicon glyphicon-edit"></i>'
                        ],
                        'pdf-download' => [
                            'label' => 'PDF',
                            'url' => route('invoices.pdf.view', [$row->id, 'download']),
                            'class' => '',
                            'icon' =>'<i class="glyphicon glyphicon-save-file"></i>'
                        ],
                        'delete' => [
                            'label' => 'Delete',
                            'url' => route('invoices.delete', $row->id),
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
        $invoice = $this->invoiceRepository->getById($invoiceId);

        $pdf = new domPDF();

        $template = view('Invoices::invoices.templates.default')
                    ->with('invoice', $invoice)
                    ->with('logo', url(config('blend.logo')))
                    ->render();

        switch ($mode) {
            case 'view':
                $pdf->stream($template, $invoice->number.'.pdf');
                break;
    
            case 'download':
                $pdf->download($template, $invoice->number.'.pdf');
                break;
        }
    }
}
