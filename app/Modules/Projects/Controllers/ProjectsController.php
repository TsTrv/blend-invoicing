<?php

namespace App\Modules\Projects\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Projects\Requests\ProjectRequest;
use App\Modules\Projects\Repositories\Interfaces\ProjectsRepositoryInterface;
use App\Modules\Clients\Repositories\Interfaces\ClientRepositoryInterface;
use Datatables;

class ProjectsController extends Controller
{
    /**
     * projectsRepository
     * @var App\Modules\Projects\Repositories\Interfaces\ProjectsRepositoryInterface
     */
    protected $projectsRepository;

    /**
     * clientRepository
     * @var App\Modules\Clients\Repositories\Interfaces\ClientRepositoryInterface
     */
    protected $clientRepository;
 
    /**
     * Construct
     * 
     * @param ProjectsRepositoryInterface $projectsRepository [description]
     */
    public function __construct(
        ProjectsRepositoryInterface $projectsRepository,
        ClientRepositoryInterface $clientRepository
    ) {
        $this->projectsRepository = $projectsRepository;
        $this->clientRepository = $clientRepository;
    }

    /**
     * Index. 
     * 
     * @return view
     */
    public function index()
    {
        return view('Projects::projects.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = $this->clientRepository->getForBladeSelect('name', 'id');

        return view('Projects::projects.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $inputs = $request->all();

        $client = $this->projectsRepository->create($inputs);

        return redirect()->route('projects.index');
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
    public function edit($id)
    {
        if (!$project = $this->projectsRepository->getById($id)) {
            return abort(403, 'Unauthorized action.');
        }

        $clients = $this->clientRepository->getForBladeSelect('name', 'id');

        $breadcrumb = [
            'name' => $project->name,
            'id' => $project->id
        ];

        return view('Projects::projects.edit', compact('project', 'clients', 'breadcrumb'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Modules\Clients\Requests\ProjectRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, $id)
    {
        $inputs = $request->all();

        $client = $this->projectsRepository->update($id, $inputs);

        return redirect()->route('projects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

     /**
     * Datatable
     * 
     * @return json
     */
    public function datatable()
    {
        return Datatables::of($this->projectsRepository->datatableCollection([], [
            'id',
            'name',
            'description',
            'client_id'
        ]))
        ->editColumn('client_id', function ($row) {
            return '<a href="'.route('clients.edit', $row->client_id).'">'.$row->client->name.'</a>';
        })
        ->addColumn('actions', function ($row) {
            return view('includes._datatable_actions', ['fields' => [
                'edit' => [
                    'label' => 'Edit',
                    'url' => route('projects.edit', $row->id),
                    'class' => '',
                    'icon' =>'<i class="glyphicon glyphicon-edit"></i>'
                ],
                'delete' => [
                    'label' => 'Delete',
                    'url' => route('projects.delete', $row->id),
                    'class' => '',
                    'icon' =>'<i class="glyphicon glyphicon-trash"></i>',
                    'onclick' => "return confirm('Are you sure you want to delete this project?')"
                ]
            ]])->render();
        })
        ->make();
    }
}
