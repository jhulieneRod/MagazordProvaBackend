<?php

namespace Agenda\Controller;

use Agenda\Utils\Render;
use Doctrine\ORM\EntityManager;
use Agenda\Controller\PessoaController;
use Agenda\Controller\ContatoController;

class IndexController extends Render {

    public function index () {
        $dados = [];
        $dados['pessoas']  = $this->getListaPessoas();
        $dados['contatos'] = $this->getListaContatos();
        $this->loadView("home", $dados);
    }

    public function getListaPessoas(){
        $controller = new PessoaController();
        return $controller->getAll();
    }

    public function getListaContatos(){
        $controller = new ContatoController();
        return $controller->getAll();
    }

    public function trataRequisicaoPessoa(){
        $controller = new PessoaController();
        $controller->trataRequisicao();
    }

    public function trataRequisicaoContato(){
        $controller = new ContatoController();
        $controller->trataRequisicao();
    }

}