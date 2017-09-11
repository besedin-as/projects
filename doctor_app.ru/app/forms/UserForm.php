<?php

namespace forms;

use Silex\Application;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UserForm {

    protected $factory;

    public function __construct(FormFactory $factory)
    {
        $this->factory = $factory;
    }

    public function getLoginForm() {
        $form = $this->factory->createNamedBuilder(null, FormType::class)
            ->add('email', EmailType::class, array(
                    'constraints' => new Assert\Email(array(
                        'message' => 'The email "{{ value }}" is not a valid email.',
                        'checkMX' => true)),
                    'error_bubbling' => false,
                )
            )
            ->add('password', PasswordType::class)
            ->getForm();

        return $form;
    }

    public function getRemindForm() {
        $form = $this->factory->createNamedBuilder(null, FormType::class)
            ->add('email', EmailType::class, array(
                    'constraints' => new Assert\Email(array(
                        'message' => 'The email "{{ value }}" is not a valid email.',
                        'checkMX' => true)),
                    'error_bubbling' => false,
                )
            )
            ->getForm();

        return $form;
    }
}