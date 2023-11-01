<?php

namespace Agenda\Entity;

use Doctrine\ORM\Mapping as ORM;
use Agenda\Entity\Contato;

/**
 * @ORM\Entity
 * @ORM\Table(name="pessoa")
 */
class Pessoa {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $nome;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $cpf;

    /**
     * @ORM\OneToMany(targetEntity="Contato", mappedBy="pessoa")
     */
    private $contatos;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }
}