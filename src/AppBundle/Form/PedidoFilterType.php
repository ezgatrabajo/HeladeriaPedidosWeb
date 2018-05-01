<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use AppBundle\Entity\GlobalValue;
use Doctrine\ORM\EntityRepository;



class PedidoFilterType extends AbstractType
{
        
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       
        
        $builder->add('fechadesde',  DateType::class, [ 'widget' => 'single_text', 'label'=>'Fecha Desde']  )
                ->add('fechahasta',  DateType::class, [ 'widget' => 'single_text', 'label'=>'Fecha Hasta']  )
                ->add('estadoid', ChoiceType::class, array(
                        'choices'   => GlobalValue::ESTADOS_SELECT,
                        'required'  => false,
                        'label'=>'Estado'))
                ->add('user', EntityType::class, array(
                            'class' => 'AppBundle:User',
                            'query_builder' => function (EntityRepository $er) {
                                return $er->createQueryBuilder('u')
                                ->orderBy('u.email', 'ASC');
                            },
                            'choice_label' => 'getTextoCombo',
                            'required'=>false
                        ));
                
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Pedido'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_Pedido';
    }


}
