<?php

namespace App\Modules\Employees\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Employees\Repositories\Interfaces\EmployeesRepositoryInterface;
use App\Modules\Employees\Repositories\Interfaces\RolesRepositoryInterface;
use App\Modules\Employees\Requests\EmployeesRequest;
use Datatables;

class EmployeesController extends Controller
{

    protected $employeesRepository;

    public function __construct(
        EmployeesRepositoryInterface $employeesRepository,
        RolesRepositoryInterface $rolesRepository
    ) {
        $this->employeesRepository = $employeesRepository;
        $this->rolesRepository = $rolesRepository;
    }

    /**
     * Index. 
     * 
     * @return view
     */
    public function index()
    {
        return view('Employees::employees.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->rolesRepository->getForBladeSelect('name', 'id');
        return view('Employees::employees.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeesRequest $request)
    {
        $inputs = $request->all();

        $employee = $this->employeesRepository->create($inputs);

        return redirect()->route('employees.show', $employee->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$employee = $this->employeesRepository->getById($id)) {
            return abort(403, 'Unauthorized action.');
        }

        $breadcrumb = [
            'name' => $employee->name,
            'id' => $employee->id
        ];

        return view('Employees::employees.show', compact('employee', 'breadcrumb'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!$employee = $this->employeesRepository->getById($id)) {
            return abort(403, 'Unauthorized action.');
        }

        $roles = $this->rolesRepository->getForBladeSelect('name', 'id');

        $breadcrumb = [
            'name' => $employee->name,
            'id' => $employee->id
        ];

        return view('Employees::employees.edit', compact('employee', 'breadcrumb', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Modules\Clients\Requests\ClientRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeesRequest $request, $id)
    {
        $inputs = $request->all();

        $employee = $this->employeesRepository->update($id, $inputs);

        return redirect()->route('employees.show', $employee->id);
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
        return Datatables::of($this->employeesRepository->datatableCollection([], [
            'id',
            'name',
            'email'
        ]))
        ->addColumn('role', function ($row) {
            return $row->roles_formatted;
        })
        ->addColumn('actions', function ($row) {
            return view('includes._datatable_actions', ['fields' => [
                'edit' => [
                    'label' => 'Edit',
                    'url' => route('employees.edit', $row->id),
                    'class' => '',
                    'icon' =>'<i class="glyphicon glyphicon-edit"></i>'
                ],
                'view' => [
                    'label' => 'View',
                    'url' => route('employees.show', $row->id),
                    'class' => '',
                    'icon' =>'<i class="glyphicon glyphicon-list"></i>'
                ],
                'delete' => [
                    'label' => 'Delete',
                    'url' => route('employees.delete', $row->id),
                    'class' => '',
                    'icon' =>'<i class="glyphicon glyphicon-trash"></i>',
                    'onclick' => "return confirm('Are you sure you want to delete this user?')"
                ]
            ]])->render();
        })
        ->make();
    }
}
