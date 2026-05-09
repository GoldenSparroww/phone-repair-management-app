<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Core\ViewWrapper;
use App\Services\CustomerService;
use Exception;

class CustomerController extends AbstractController
{
    public function __construct(
        protected ViewWrapper $view,
        private CustomerService $customerService
    ) {
        parent::__construct($view);
    }

    public function create(): void
    {
        if ($this->isPost()) {
            try {
                $this->customerService->createNewCustomer(
                    $this->getPostParam('first_name'),
                    $this->getPostParam('last_name'),
                    $this->getPostParam('phone'),
                    $this->getPostParam('email'),
                    $this->getPostParam('city'),
                    $this->getPostParam('street'),
                    (int)$this->getPostParam('house_no'),
                    (int)$this->getPostParam('zip')
                );

                // Po úspěšném založení se vrátíme na formulář pro přidání opravy
                $this->redirect('/repair/create');
            } catch (Exception $e) {
                echo $this->view->render('CustomerCreate.twig', [
                    'error' => $e->getMessage()
                ]);
                return;
            }
        }

        echo $this->view->render('CustomerCreate.twig');
    }
}