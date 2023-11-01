<?php

require 'vendor/autoload.php';
include 'bootstrap.php';

Use Agenda\Controller\IndexController;
Use Agenda\Controller\PessoaController;
Use Agenda\Controller\ContatoController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe o JSON da requisição POST e decodifica-o em um objeto PHP
    $json = file_get_contents('php://input');
    $data = json_decode($json);

    // Verifica se o JSON foi decodificado com sucesso
    if ($data) {
        $target = isset($data->target) ? $data->target : 'index';
        $function = isset($data->action) ? $data->action : 'index';

        if($target == 'pessoa'){
            $controller = new PessoaController();
        }else if($target == 'contato'){
            $controller = new ContatoController();
        }else{
            $controller = new IndexController();
        }
        if($response = $controller->$function($data)){
            echo json_encode($response);
        }else{
            echo false;
        }
    } else {
        // O JSON não pôde ser decodificado
        http_response_code(400); // Resposta de erro, se necessário
        echo "Erro ao decodificar JSON";
    }
} else {
    // A requisição não é um POST
    http_response_code(405); // Método não permitido
    echo "Método não permitido";
}