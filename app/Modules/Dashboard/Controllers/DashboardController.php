<?php

namespace App\Modules\Dashboard\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Timelogs\Repositories\Interfaces\TimelogsRepositoryInterface;

class DashboardController extends Controller
{
	protected $timelogsRepository;

    public function __construct(TimelogsRepositoryInterface $timelogsRepository)
    {
    	$this->timelogsRepository = $timelogsRepository;
    }
 	
 	/**
 	 * [index description]
 	 * @return [type] [description]
 	 */
    public function index()
    {
    	$timeLogs = $this->timelogsRepository->thisWeek();
        return view('Dashboard::dashboard.index', compact('timeLogs'));
    }
}
