<?php
namespace App\Controllers;

use App\Core\AbstractController;
use App\Services\RepairService;

class RepairController extends AbstractController
{
    public function __construct(
        private readonly RepairService $repairService
    )
    {
        parent::__construct();
    }

    public function index(): void
    {
        $repairs = $this->repairService->getAllRepairs();

        echo $this->view->render('Repair.twig', [
            'repairs' => $repairs
        ]);
    }
}