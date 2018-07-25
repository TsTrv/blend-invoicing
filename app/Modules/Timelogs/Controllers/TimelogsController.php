<?php

namespace App\Modules\Timelogs\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Timelogs\Repositories\Interfaces\TimelogsRepositoryInterface;
use App\Modules\Employees\Repositories\Interfaces\EmployeesRepositoryInterface;
use App\Modules\Projects\Repositories\Interfaces\ProjectsRepositoryInterface;
use App\Modules\Timelogs\Requests\TimelogRequest;
use Datatables;

class TimelogsController extends Controller
{
    protected $timelogsRepository;

    public function __construct(
        TimelogsRepositoryInterface $timelogsRepository,
        EmployeesRepositoryInterface $employeesrepository,
        ProjectsRepositoryInterface $projectsRepository
    ) {
        $this->timelogsRepository = $timelogsRepository;
        $this->employeesrepository = $employeesrepository;
        $this->projectsRepository = $projectsRepository;
    }

    /**
     * Index. 
     * 
     * @return view
     */
    public function index()
    {
        return view('Timelogs::timelogs.index');
    }

    
    public function create()
    {
        $employees = $this->employeesrepository->getForBladeSelect('name', 'id');
        $projects = $this->projectsRepository->getForBladeSelect('name', 'id');

        return view('Timelogs::timelogs.create', compact('employees', 'projects'));
    }

    
    public function store(TimelogRequest $request)
    {
        $inputs = $request->all();

        $quote = $this->timelogsRepository->create($inputs);
        
        return redirect(route('timelogs.index'));
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
        $timelog = $this->timelogsRepository->getById($id);
        $employees = $this->employeesrepository->getForBladeSelect('name', 'id');
        $projects = $this->projectsRepository->getForBladeSelect('name', 'id');

        return view('Timelogs::timelogs.edit', compact('timelog', 'employees', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Modules\Clients\Requests\TimelogRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TimelogRequest $request, $id)
    {
        $inputs = $request->all();

        $quote = $this->timelogsRepository->update($id,$inputs);
        
        return redirect(route('timelogs.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect(route('timelogs.index'));
    }

     /**
     * Datatable
     * 
     * @return json
     */
    public function datatable()
    {
        return Datatables::of($this->timelogsRepository->datatableCollection(
            [],
            [ 'id', 'user_id', 'project_id', 'total', 'date']))
            ->editColumn('user_id', function ($row) {
                return '<a href="'.route('employees.show', $row->user->id).'">'.$row->user->name.'</a>';
            })
            ->editColumn('project_id', function ($row) {
                return '<a href="'.route('projects.edit', $row->project->id).'">'.$row->project->name.'</a>';
            })
            ->editColumn('date', function ($row) {
                return $row->date_formatted;
            })
            ->addColumn('actions', function ($row) {
                return view('includes._datatable_actions', ['fields' => [
                    'edit' => [
                        'label' => 'Edit',
                        'url' => route('timelogs.edit', $row->id),
                        'class' => '',
                        'icon' =>'<i class="glyphicon glyphicon-edit"></i>'
                    ],
                    'delete' => [
                        'label' => 'Delete',
                        'url' => route('timelogs.destroy', $row->id),
                        'class' => '',
                        'icon' =>'<i class="glyphicon glyphicon-trash"></i>',
                        'onclick' => "return confirm('If you delete this client you will also delete any invoices, quotes and payments related to this client. Are you sure you want to permanently delete this client?')"
                    ]
                ]])->render();
            })
            ->make();
    }
}
