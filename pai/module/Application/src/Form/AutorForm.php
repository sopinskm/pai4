<?php

namespace Application\Form;


use Laminas\Form\Form;
use Laminas\InputFilter\InputFilterProviderInterface;

class AutorForm extends Form implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('autor');

        $this->setAttributes(['method' => 'post', 'class' => 'form']);
        $this->add([
            'name' => 'imie',
            'type' => 'Text',
            'options' => [
                'label' => 'Imię',
            ],
            'attributes' => ['class' => 'form-control'],
        ]);
        $this->add([
            'name' => 'nazwisko',
            'type' => 'Text',
            'options' => [
                'label' => 'Nazwisko',
            ],
            'attributes' => ['class' => 'form-control'],
        ]);
        $this->add([
            'name' => 'zapisz',
            'type' => 'Submit',
            'attributes' => [
                'value' => 'Zapisz',
                'class' => 'btn btn-primary',
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            [
                'name' => 'imie',
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [],
            ],
            [
                'name' => 'nazwisko',
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [],
            ],
        ];
    }
}