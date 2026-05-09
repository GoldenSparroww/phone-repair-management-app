<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Services\InvoiceService;
use App\Core\ViewWrapper;
use App\Services\RepairService;
use Dompdf\Dompdf;
use Dompdf\Options;

class InvoiceController extends AbstractController
{
    public function __construct(
        protected ViewWrapper  $view,
        private InvoiceService $invoiceService,
    )
    {
        parent::__construct($view);
    }

    public function create(): void
    {
        if ($this->isPost()) {
            $repairId = (int)$this->getPostParam('repair_id');
            $method = $this->getPostParam('method');

            try {
                $this->invoiceService->createInvoiceForRepair($repairId, $method);
                $this->redirect('/repair/browse');
            } catch (\Exception $e) {
                echo $this->view->render('InvoiceCreate.twig', [
                    'error' => $e->getMessage(),
                    'repairs' => $this->invoiceService->getRepairedRepairs()
                ]);
            }
            return;
        }

        echo $this->view->render('InvoiceCreate.twig', [
            'repairs' => $this->invoiceService->getRepairedRepairs()
        ]);
    }

    public function download(string $id): void
    {
        $repair = $this->invoiceService->getRepairById((int)$id);

        $html = $this->view->render('InvoicePdfTemplate.twig', ['repair' => $repair]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        // Vygenerování a odeslání do prohlížeče ke stažení
        $dompdf->render();
        $dompdf->stream("faktura-{$id}.pdf", ["Attachment" => true]);
        exit;
    }
}