<?php
namespace App\Core;

/**
 * Třída, kteoru každý controller dědí. Existuje kvůli centralizaci správy ViewWrapperu
 */
abstract class AbstractController {
    protected ViewWrapper $view;

    public function __construct() {
        $this->view = new ViewWrapper();
    }
}
