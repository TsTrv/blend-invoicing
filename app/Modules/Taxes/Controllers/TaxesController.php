<?php

namespace App\Modules\Taxes\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Taxes\Repositories\Interfaces\TaxRepositoryInterface;
use Datatables;

class TaxesController extends Controller
{
    /**
     * [$taxRepository description]
     * @var [type]
     */
    protected $taxRepository;
 
    /**
     * Construct
     * 
     * @param TaxRepositoryInterface $taxRepository [description]
     */
    public function __construct(TaxRepositoryInterface $taxRepository)
    {
        $this->taxRepository = $taxRepository;
    }

    /**
     * [index description]
     * 
     * @return [type] [description]
     */
    public function index()
    {
        return view('Taxes::taxes.index');
    }

     /**
     * Datatable
     * 
     * @return json
     */
    public function datatable()
    {
        return Datatables::of($this->taxRepository->datatableCollection([],['id', 'name', 'percent']))->make();
    }
}
