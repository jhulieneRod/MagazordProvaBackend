<?php

namespace Agenda\Utils;

use Doctrine\ORM\EntityManagerInterface;

abstract class Render {

    protected $entityManager;

    public function __construct(){
        $this->entityManager = getEntityManager();
    }
    
    public function loadView ($view, $args) {
        extract($args);
        require_once "./src/View/$view.php";
    }

    public function create($data){}

    public function edit($data){}

    public function delete($data){}

}