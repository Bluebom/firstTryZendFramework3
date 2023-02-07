<?php

namespace Pessoa\Controller;

use Pessoa\Form\PessoaForm;
use Pessoa\Model\Pessoa;
use Pessoa\Model\PessoaTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class PessoaController extends AbstractActionController
{
    private $table;

    /**
     * @param PessoaTable $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }
    public function __construct($table)
    {
        $this->setTable($table);
    }

    /**
     * Ao retornar uma instância de ViewModel ele vai apontar para a view
     * com o mesmo nome do método sem 'Action', nesse exemplo apontara para
     * index.phtml.
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel(['pessoas' => $this->table->all()]);
    }
    public function adicionarAction()
    {
        $form = new PessoaForm();
        $form->get('submit')->setValue('Adicionar');
        $request = $this->getRequest();
        if(!$request->isPost()){
            return new ViewModel(['form' => $form]);
        }
        $pessoa = new Pessoa();
        $form->setData($request->getPost());
        if(!$form->isValid()){
            return new ViewModel(['form' => $form]);
        }
        $pessoa->exchangeArray($form->getData());
        $this->table->salvarPessoa($pessoa);
        return $this->redirect()->toRoute('pessoa');
    }

    public function editarAction()
    {
        $route = $this->getEvent()->getRouteMatch();
        $id = (int) $route->getParam('id');
        if($id === 0){
            return $this->redirect()->toRoute('pessoa', ['action'=>'adicionar']);
        }
        try{
            $pessoa = $this->table->getPessoa($id);
        }catch (\Exception $e) {
            return $this->redirect()->toRoute('pessoa');
        }
        $form = new PessoaForm();
        $form->bind($pessoa);
        $form->get('submit')->setValue('Salvar');
        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];
        if(!$request->isPost()){
            return new ViewModel($viewData);
        }
        $form->setData($request->getPost());
        if(!$form->isValid()){
            return new ViewModel(['form' => $form]);
        }
        $this->table->salvarPessoa($form->getData());
        return $this->redirect()->toRoute('pessoa');
    }
    public function removerAction()
    {
        $route = $this->getEvent()->getRouteMatch();
        $id = (int) $route->getParam('id');
        $request = $this->getRequest();
        $del = $request->getPost('del', 'Não');
        $viewData = ['id' => $id];
        if(!$request->isPost() && $id !== 0){
            return new ViewModel($viewData);
        }
        if($del == 'Sim'){
            $this->table->deletarPessoa($id);
        }
        return $this->redirect()->toRoute('pessoa');

    }
}