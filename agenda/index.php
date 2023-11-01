<?php

require 'vendor/autoload.php';
include 'bootstrap.php';

Use Agenda\Controller\IndexController;

$IndexController = new IndexController();
$IndexController->index();
