<?php
namespace App\Controllers;

use App\Core\AbstractController;
use App\Core\Session;
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

    public function detail(string $id): void
    {
        $repairId = (int)$id;
        $repair = $this->repairService->getRepairById($repairId);

        if (!$repair) {
            $this->redirect('/repair/browse');
        }

        // Získání techniků pro roletku ve formuláři přiřazení
        $technicians = $this->repairService->getAllTechnicians();

        var_dump($repair);
        echo $this->view->render('RepairsDetail.twig', [
            'repair' => $repair,
            'technicians' => $technicians
        ]);
    }

    public function assign(string $id): void
    {
        if ($this->isPost()) {
            $repairId = (int)$id;
            $employeeId = (int)$this->getPostParam('technician_id');

            try {
                // Volání doménové logiky, která přesune stav opravy
                $this->repairService->assignTechnicianToRepair($repairId, $employeeId);
            } catch (Exception $e) {
            }

            // Po zpracování přesměrujeme uživatele zpět na detail stejné opravy
            $this->redirect('/repair/detail/' . $repairId);
        }
    }

    public function waiting(): void
    {
        // Získání ID přihlášeného technika ze session
        $user = Session::get('user');
        $techniciansRepairs = $this->repairService->getRepairsForTechnician($user['id']);
        $pricingList = $this->repairService->getAllPricingItems();

        echo $this->view->render('RepairsWaiting.twig', [
            'repairs' => $techniciansRepairs,
            'pricingList' => $pricingList
        ]);
    }

    public function finish(string $id): void
    {
        if ($this->isPost()) {
            try {
                $this->repairService->submitServiceAction(
                    (int)$id,
                    $this->getPostParam('notes'),
                    (int)$this->getPostParam('price_id')
                );
                $this->redirect('/repair/waiting');
            } catch (\Exception $e) {
                $this->redirect('/repair/waiting?error=' . urlencode($e->getMessage()));
            }
        }
    }
}