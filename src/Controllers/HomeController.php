<?php
namespace App\Controllers;

use App\Core\AbstractController;

class HomeController extends AbstractController
{
    public function index(): void
    {
        echo $this->view->render('Home.twig', [
            'title' => 'Vítejte v systému opravny',
            'message' => 'Systém je připraven k použití.'
        ]);
    }
}