<?php

namespace App\Modules\Currencies\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Currencies\Repositories\Interfaces\CurrencyRepositoryInterface;
use Datatables;

class CurrenciesController extends Controller
{
    /**
     * [$currencyRepository description]
     * @var [type]
     */
    protected $currencyRepository;
 
    /**
     * Construct
     * 
     * @param TaxRepositoryInterface $taxRepository [description]
     */
    public function __construct(CurrencyRepositoryInterface $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * [index description]
     * 
     * @return [type] [description]
     */
    public function index()
    {
        return view('Currencies::currencies.index');
    }

     /**
     * Datatable
     * 
     * @return json
     */
    public function datatable()
    {
        return Datatables::of($this->currencyRepository->datatableCollection([], ['id', 'code', 'name', 'symbol']))->make();
    }
}
