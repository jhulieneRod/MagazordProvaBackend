<?php

namespace Agenda\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="contato")
 */
class Contato
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $tipo;

    /**
     * @ORM\Column(type="string")
     */
    private $descricao;

    /**
     * @ORM\ManyToOne(targetEntity="Pessoa", inversedBy="contatos")
     * @ORM\JoinColumn(name="id_pessoa", referencedColumnName="id")
     */
    private $pessoa;

    private $tipoDescritivo;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getTipo(){
        return $this->tipo;
    }

    public function setTipo($tipo){
        $this->tipo = $tipo;
    }

    public function getDescricao(){
        return $this->descricao;
    }

    public function setDescricao($descricao){
        $this->descricao = $descricao;
    }

    public function getPessoa(){
        return $this->pessoa;
    }

    public function setPessoa($pessoa){
        $this->pessoa = $pessoa;
    }

    public function getTipoDescritivo(){
        if(!isset($this->tipoDescritivo)){
            if($this->getTipo() === "1"){
                $this->tipoDescritivo = 'Email';
            }else{
                $this->tipoDescritivo = 'Telefone';
            }
        }

        return $this->tipoDescritivo;
    }
}