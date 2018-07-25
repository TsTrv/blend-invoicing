<?php

namespace App\Modules\Users\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Users\Repositories\Interfaces\UsersRepositoryInterface;
use App\Modules\Users\Requests\UserRequest;
use Datatables;

class UsersController extends Controller
{
    private $usersRepository;
    
    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function index()
    {
        return view('Users::users.index');
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
        $users = $this->usersRepository->getById($id);

        return view('Users::users.edit', compact('users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Modules\User\Requests\UserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $inputs = $request->all();

        $quote = $this->usersRepository->update($id,$inputs);
        
        return redirect(route('users.index'));
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
        return Datatables::of($this->usersRepository->datatableCollection(
            [],
            [ 'id', 'name', 'company', 'email']))
            ->addColumn('actions', function ($row) {
                return view('includes._datatable_actions', ['fields' => [
                    'edit' => [
                        'label' => 'Edit',
                        'url' => route('users.edit', $row->id),
                        'class' => '',
                        'icon' =>'<i class="glyphicon glyphicon-edit"></i>'
                    ],
                    'delete' => [
                        'label' => 'Delete',
                        'url' => route('users.delete', $row->id),
                        'class' => '',
                        'icon' =>'<i class="glyphicon glyphicon-trash"></i>',
                        'onclick' => "return confirm('If you delete this client you will also delete any invoices, quotes and payments related to this client. Are you sure you want to permanently delete this client?')"
                    ]
                ]])->render();
            })
            ->make();
    }
}
