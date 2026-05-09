<?php
namespace App\Controllers;

use App\Core\AbstractController;
use App\Core\ViewWrapper;
use App\Services\RepairService;

class DashboardController extends AbstractController
{
    public function __construct(
        protected ViewWrapper $view,
        private RepairService $repairService
    ) {
        parent::__construct($view);
    }

    public function index(): void
    {
        $today = date('Y-m-d');
        $lastWeek = date('Y-m-d', strtotime('-7 days'));

        echo $this->view->render('Dashboard.twig', [
            'countToday' => $this->repairService->getRepairsCountSince($today),
            'countWeek'  => $this->repairService->getRepairsCountSince($lastWeek)
        ]);
    }
}