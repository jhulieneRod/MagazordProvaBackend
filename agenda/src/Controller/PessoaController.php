<?php

namespace Agenda\Controller;

use Agenda\Utils\Render;
use Agenda\Entity\Pessoa;

class PessoaController extends Render {

    public function getAll () {
        $pessoaRepository = $this->entityManager->getRepository(Pessoa::class);
        $pessoas = $pessoaRepository->findAll();

        return $pessoas;
    }

    public function create($pessoa){
        $nome = isset($pessoa->nome) ? $pessoa->nome : '';
        $cpf  = isset($pessoa->cpf) ? $pessoa->cpf : '';

        if($nome != '' && $cpf != ''){
            $novaPessoa = new Pessoa();
            $novaPessoa->setNome($nome);
            $novaPessoa->setCpf($cpf);

            $this->entityManager->persist($novaPessoa);
            $this->entityManager->flush();
        }

        return true;
    }

    public function edit($data){
        $id   = isset($data->id) ? $data->id : '';
        $nome = isset($data->nome) ? $data->nome : '';
        $cpf  = isset($data->cpf) ? $data->cpf : '';

        if($nome != '' && $cpf != '' && $id != ''){
            if($pessoa = $this->getPessoaById($id)){
                $pessoa->setNome($nome);
                $pessoa->setCpf($cpf);
                $this->entityManager->flush();
                return true;
            }
        }

        return false;
    }

    public function delete($data){
        $id = isset($data->id) ? $data->id : '';
        if($id == ''){
            return false;
        }
        $pessoa = $this->getPessoaById($id);
        
        if($pessoa){
            $this->entityManager->remove($pessoa);
            $this->entityManager->flush();
        }

        return true;
    }

    public function getPessoaById($id){
        $pessoaRepository = $this->entityManager->getRepository(Pessoa::class);
        if($pessoa = $pessoaRepository->find($id)){
            return $pessoa;
        }
        return false;
    }
}