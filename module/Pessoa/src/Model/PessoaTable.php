<?php

namespace Pessoa\Model;

use http\Exception\RuntimeException;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGatewayInterface;

class PessoaTable{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->setTableGateway($tableGateway);
    }

    /**
     * @return TableGatewayInterface
     */
    public function getTableGateway()
    {
        return $this->tableGateway;
    }

    /**
     * @param TableGatewayInterface $tableGateway
     */
    public function setTableGateway($tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function all(){
        return $this->getTableGateway()->select(function (Select $select) {
            $select->order('id ASC');
        });
    }

    public function getPessoa($id){
        $id = (int) $id;
        $rowset = $this->getTableGateway()->select(['id' => $id]);
        $row = $rowset->current();
        if(!$row){
            throw new \Exception(sprintf('Não foi encontrado o id %id', $id));
        }
        return $row;
    }

    public function salvarPessoa(Pessoa $pessoa){
        $data = [
            'nome' => $pessoa->getNome(),
            'sobrenome' => $pessoa->getSobrenome(),
            'email' => $pessoa->getEmail(),
            'situacao' => $pessoa->getSituacao()
        ];

        $id = (int) $pessoa->getId();
        if($id === 0){
            $this->getTableGateway()->insert($data);
            return;
        }
        $this->getTableGateway()->update($data, ['id' => $id]);
    }

    public function deletarPessoa($id){
        $this->getTableGateway()->delete(['id' => (int)$id]);
    }
}
