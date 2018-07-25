<?php

namespace App\Modules\Clients\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Clients\Requests\ClientRequest;
use App\Modules\Clients\Repositories\Interfaces\ClientRepositoryInterface;
use App\Helpers\Formatter;
use Datatables;

class ClientsController extends Controller
{

    /**
     * ClientRepositoryInterface
     * 
     * @var App\Modules\Clients\Repositories\Interfaces\ClientRepositoryInterface
     */
    protected $clientRepository;

    /**
     * Construct
     * 
     * @param ClientRepositoryInterface $clientRepository [description]
     */
    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * Index. 
     * 
     * @return view
     */
    public function index()
    {
        return view('Clients::clients.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Clients::clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        $inputs = $request->all();

        $client = $this->clientRepository->create($inputs);

        return redirect()->route('clients.show', $client->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$client = $this->clientRepository->getById($id)) {
            return abort(403, 'Unauthorized action.');
        }

        $breadcrumb = [
            'name' => $client->name,
            'id' => $client->id
        ];

        return view('Clients::clients.show', compact('client', 'breadcrumb'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!$client = $this->clientRepository->getById($id)) {
            return abort(403, 'Unauthorized action.');
        }

        $breadcrumb = [
            'name' => $client->name,
            'id' => $client->id
        ];

        return view('Clients::clients.edit', compact('client', 'breadcrumb'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Modules\Clients\Requests\ClientRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, $id)
    {
        if (!$client = $this->clientRepository->getById($id)) {
            return abort(403, 'Unauthorized action.');
        }

        $inputs = $request->all();

        $this->clientRepository->update($client->id, $inputs);

        return redirect()->route('clients.show', $client->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$client = $this->clientRepository->getById($id)) {
            return abort(403, 'Unauthorized action.');
        }
        $this->clientRepository->delete($id);

        return redirect()->route('clients.index');
    }

    /**
     * Datatable
     * 
     * @return json
     */
    public function datatable()
    {
        return Datatables::of($this->clientRepository->datatableCollection(
                [],
                ['id', 'name', 'email', 'phone', 'active']))
                ->addColumn('name', function ($row) {
                    return '<a href="'.route('clients.edit', $row->id).'">'.$row->name.'</a>';
                })
                ->editColumn('active', function ($row) {
                    return $row->active_formatted;
                })
                ->addColumn('balance', function ($row) {
                    return $row->balance_formatted;
                })
                ->addColumn('actions', function ($row) {
                    return view('includes._datatable_actions', ['fields' => [
                        'view' => [
                            'label' => 'View',
                            'url' => route('clients.show', $row->id),
                            'class' => '',
                            'icon' =>'<i class="glyphicon glyphicon-search"></i>'
                        ],
                        'edit' => [
                            'label' => 'Edit',
                            'url' => route('clients.edit', $row->id),
                            'class' => '',
                            'icon' =>'<i class="glyphicon glyphicon-edit"></i>'
                        ],
                        'delete' => [
                            'label' => 'Delete',
                            'url' => route('clients.delete', $row->id),
                            'class' => '',
                            'icon' =>'<i class="glyphicon glyphicon-trash"></i>',
                            'onclick' => "return confirm('If you delete this client you will also delete any invoices, quotes and payments related to this client. Are you sure you want to permanently delete this client?')"
                        ]
                    ]])->render();
                })
            ->make();
    }

    public function selectJson(Request $request, $filter = false){

        return $this->clientRepository->getSelect2Data($request->get('q'), $request->get('page'));

    }
}
