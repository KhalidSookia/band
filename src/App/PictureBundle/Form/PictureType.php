<?php

namespace App\PictureBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\SecurityContext;
/** 
*@DI\Service("form.type.picture") 
*/
class PictureType extends AbstractType
{
    /**
     * @var \Symfony\Component\Security\Core\SecurityContext
     */
    protected $securityContext;
    /**
     * @DI\InjectParams({"securityContext" = @DI\Inject("security.context")})
     *
     * @param \Symfony\Component\Security\Core\SecurityContext $context
     */
    public function __construct(SecurityContext $securityContext){
        $this->securityContext = $securityContext;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $user = $this->securityContext()->getToken()->getUser()->getId();

        $builder
            ->add('file')
            ->add('collection', 'entity', array(
                'class' => 'AppPictureBundle:Collection',
                'property' => 'name',
                'query_builder' => function (EntityRepository $er) {
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
