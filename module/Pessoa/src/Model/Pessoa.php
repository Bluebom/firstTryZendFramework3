<?php

namespace Pessoa\Model;
use Zend\Stdlib\ArraySerializableInterface;

class Pessoa implements ArraySerializableInterface
{
    private $id;
    private $nome;
    private $sobrenome;
    private $email;
    private $situacao;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getSobrenome()
    {
        return $this->sobrenome;
    }

    /**
     * @param mixed $sobrenome
     */
    public function setSobrenome($sobrenome)
    {
        $this->sobrenome = $sobrenome;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * @param mixed $situacao
     */
    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
    }

    public function exchangeArray(array $data){
        $this->setId(!empty($data['id']) ? $data['id'] : null);
        $this->setNome(!empty($data['nome']) ? $data['nome'] : null);
        $this->setSobrenome(!empty($data['sobrenome']) ? $data['sobrenome'] : null);
        $this->setEmail( !empty($data['email']) ? $data['email'] : null);
        $this->setSituacao(!empty($data['situacao']) ? $data['situacao'] : null);
    }

    public function getArrayCopy()
    {
        return [
            'id' => $this->getId(),
            'nome' => $this->getNome(),
            'sobrenome' => $this->getSobrenome(),
            'email' => $this->getEmail(),
            'situacao' => $this->getSituacao()
        ];
    }
}