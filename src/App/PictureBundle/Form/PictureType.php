<?php

namespace App\PictureBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\SecurityContext;

class PictureType extends AbstractType
{
    private $securityContext;

    public function __construct(SecurityContext $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $user = $this->securityContext->getToken()->getUser()->getId();
        if (!$user) {
            throw new \LogicException(
                'The FriendMessageFormType cannot be used without an authenticated user!'
            );
        }

        $builder
            ->add('file')
            ->add('collection', 'entity', array(
                'class' => 'AppPictureBundle:Collection',
                'property' => 'name',
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('c')
                        ->where('c.user = :user')
                        ->setParameter('user', $user);
                },
                ));
        
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\PictureBundle\Entity\Picture'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_picturebundle_picture';
    }
}
