<?php
namespace App\Controllers;

use App\Core\AbstractController;
use App\Core\ViewWrapper;
use App\DTO\NewRepairDTO;
use App\Services\RepairService;
use Exception;

class RepairController extends AbstractController
{
    public function __construct(
        protected ViewWrapper $view,
        private RepairService $repairService
    ) {
        parent::__construct($view);
    }

    public function browse(): void
    {
        $repairs = $this->repairService->getAllRepairs();
        echo $this->view->render('RepairsBrowse.twig', [
            'repairs' => $repairs
        ]);
    }

    public function create(): void
    {
        if ($this->isPost()) {
            try {
                // Vytvoření DTO přímo z parametrů požadavku
                $dto = new NewRepairDTO(
                    $this->getPostParam('customer_phone'),
                    $this->getPostParam('brand'),
                    $this->getPostParam('model'),
                    $this->getPostParam('serial'),
                    $this->getPostParam('start_date'),
                    $this->getPostParam('end_date'),
                    $this->getPostParam('description')
                );

                // Služba nyní přijímá objekt typu NewRepairDTO
                $this->repairService->createNewRepair($dto);

                $this->redirect('/repair/browse');
            } catch (Exception $e) {
                echo $this->view->render('RepairsCreate.twig', [
                    'error' => $e->getMessage()
                ]);
            }
            return;
        }

        echo $this->view->render('RepairsCreate.twig');
    }
}