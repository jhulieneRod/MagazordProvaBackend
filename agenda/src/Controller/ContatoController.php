<?php

namespace Agenda\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Agenda\Utils\Render;
use Agenda\Entity\Contato;
use Agenda\Controller\PessoaController;

class ContatoController extends Render {

    public function getAll () {
        $contatoRepository = $this->entityManager->getRepository(Contato::class);
        $contatos = $contatoRepository->findAll();

        return $contatos;
    }

    public function create($contato){
        $decricao = isset($contato->descricao) ? $contato->descricao : '';
        $tipo  = isset($contato->tipo) ? $contato->tipo : '';
        $pessoaId = isset($contato->pessoaId)  ? $contato->pessoaId : '';

        if($decricao != '' && $tipo != '' && $pessoaId != ''){
            if($pessoa = $this->getPessoaContatoById($pessoaId)){
                $novoContato = new Contato();
                $novoContato->setDescricao($decricao);
                $novoContato->setTipo($tipo);
                $novoContato->setPessoa($pessoa);

                $this->entityManager->persist($novoContato);
                $this->entityManager->flush();
            }
        }

        return true;
    }

    public function edit($data){
        $id       = isset($data->id)        ? $data->id : '';
        $decricao = isset($data->descricao) ? $data->descricao : '';
        $tipo     = isset($data->tipo)      ? $data->tipo : '';
        $pessoaId = isset($data->pessoaId)  ? $data->pessoaId : '';

        if($decricao != '' && $tipo != '' && $id != '' && $pessoaId != ''){
            if($contato = $this->getContatoById($id)){
                if($pessoa = $this->getPessoaContatoById($pessoaId)){
                    $contato->setDescricao($decricao);
                    $contato->setTipo($tipo);
                    $contato->setPessoa($pessoa);
                    $this->entityManager->flush();
                    return true;
                }
            }
        }

        return false;
    }

    public function delete($data){
        $id = isset($data->id) ? $data->id : '';
        if($id == ''){
            return false;
        }
        $contato = $this->getContatoById($id);
        
        if($contato){
            $this->entityManager->remove($contato);
            $this->entityManager->flush();
        }

        return true;
    }

    protected function getContatoById($id){
        $contatoRepository = $this->entityManager->getRepository(Contato::class);
        if($contato = $contatoRepository->find($id)){
            return $contato;
        }
        return false;
    }

    protected function getPessoaContatoById($id){
        $controller = new PessoaController();
        return $controller->getPessoaById($id);
    }
}