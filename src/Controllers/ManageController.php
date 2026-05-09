<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Core\ViewWrapper;
use App\Services\RepairService;
use Exception;

class ManageController extends AbstractController
{
    public function __construct(
        protected ViewWrapper $view,
        private RepairService $repairService
    ) {
        parent::__construct($view);
    }

    /**
     * Zpracovává URL: /manage/assignments
     */
    public function assignments(): void
    {
        // 1. Zpracování POST požadavku (odeslání formuláře s přiřazením)
        if ($this->isPost()) {
            $repairId = (int)$this->getPostParam('repair_id');
            $technicianId = (int)$this->getPostParam('technician_id');

            try {
                // Volání doménové logiky pro změnu stavu
                $this->repairService->assignTechnicianToRepair($repairId, $technicianId);
            } catch (Exception $e) {
                // Zachycení chyby (např. nepovolená změna stavu)
                echo $this->view->render('ManageAssignments.twig', [
                    'error' => $e->getMessage(),
                    'repairs' => $this->repairService->getUnassignedRepairs(),
                    'technicians' => $this->repairService->getAllTechnicians()
                ]);
                return;
            }

            // Přesměrování po úspěšném přiřazení zabrání znovuvyslání formuláře při obnovení stránky
            $this->redirect('/manage/assignments');
            return;
        }

        // 2. Zpracování GET požadavku (zobrazení stránky)
        $unassignedRepairs = $this->repairService->getUnassignedRepairs();
        $technicians = $this->repairService->getAllTechnicians();

        echo $this->view->render('ManageAssignments.twig', [
            'repairs' => $unassignedRepairs,
            'technicians' => $technicians
        ]);
    }
}