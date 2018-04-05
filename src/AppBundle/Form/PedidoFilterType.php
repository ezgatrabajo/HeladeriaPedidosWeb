<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Entity\GlobalValue;



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
                        'label'=>'Estado'));
                ;
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
