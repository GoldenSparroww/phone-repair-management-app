<?php
namespace App\Controllers;

use App\Core\AbstractController;
use App\Core\ViewWrapper;

class HomeController extends AbstractController
{
    public function __construct(
        protected ViewWrapper $view
    )
    {
        parent::__construct($view);
    }

    public function index(): void
    {
        echo $this->view->render('Home.twig', [
            'title' => 'Vítejte v systému opravny',
            'message' => 'Systém je připraven k použití.'
        ]);
    }
}