<?php
namespace App\Controllers;

use App\Core\AbstractController;
use App\Core\ViewWrapper;
use App\Services\RepairService;

/**
 * Kontroler pro hlavní přehled (dashboard).
 * Zajišťuje agregaci základních statistik a jejich zobrazení na úvodní obrazovce.
 */
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
        $countWeek = date('Y-m-d', strtotime('-7 days'));
        $lastYear = date('Y-m-d', strtotime('-356 days'));

        echo $this->view->render('Dashboard.twig', [
            'countWeek' => $this->repairService->getRepairsCountSince($countWeek),
            'countYear'  => $this->repairService->getRepairsCountSince($lastYear)
        ]);
    }
}