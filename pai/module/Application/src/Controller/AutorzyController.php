<?php

namespace Application\Controller;

use Application\Form\AutorForm;
use Application\Model\Autor;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class AutorzyController extends AbstractActionController
{
    public function __construct(public Autor $autor, public AutorForm $autorForm)
    {
    }

    public function listaAction()
    {
        return [
            'autorzy' => $this->autor->pobierzWszystko(),
        ];
    }

    public function dodajAction()
    {
        $this->autorForm->get('zapisz')->setValue('Dodaj');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->autorForm->setData($request->getPost());

            if ($this->autorForm->isValid()) {
                $this->autor->dodaj($request->getPost());

                return $this->redirect()->toRoute('autorzy');
            }
        }

        return ['tytul' => 'Dodawanie autora', 'form' => $this->autorForm];
    }

    public function edytujAction()
    {
        $id = (int)$this->params()->fromRoute('id');
        if (empty($id)) {
            $this->redirect()->toRoute('autorzy');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->autorForm->setData($request->getPost());

            if ($this->autorForm->isValid()) {
                $this->autor->aktualizuj($id, $request->getPost());

                return $this->redirect()->toRoute('autorzy');
            }
        } else {
            $daneAutora = $this->autor->pobierz($id);
            $this->autorForm->setData($daneAutora);
        }

        $viewModel = new ViewModel(['tytul' => 'Edytuj autora', 'form' => $this->autorForm]);
        $viewModel->setTemplate('application/autorzy/dodaj');

        return $viewModel;
    }

    public function usunAction()
    {
        $id = (int)$this->params()->fromRoute('id');
        if (empty($id)) {
            $this->redirect()->toRoute('autorzy');
        }

        $this->autor->usun($id);

        return $this->redirect()->toRoute('autorzy');
    }

    public function promptusunAction()
    {
        $id = (int)$this->params()->fromRoute('id');
        if (empty($id)) {
            $this->redirect()->toRoute('autorzy');
        }
        return [
            'autor' => $this->autor->pobierz($id),
        ];
    }

    public function szczegolyAction()
    {
        $daneAutora = $this->autor->pobierz($this->params('id'));
        return ['autor' => $daneAutora];
    }
}
