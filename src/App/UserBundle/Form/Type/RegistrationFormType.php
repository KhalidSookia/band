<?php

namespace App\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        // add your custom field
        $builder->add('name')
                ->add('surname')
                 ;
        parent::buildForm($builder, $options);
    }

    public function getName()
    {
        return 'app_user_registration';
    }
}