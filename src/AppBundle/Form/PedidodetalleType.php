<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Entity\GlobalValue;

class PedidodetalleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('producto' )
        ->add('nropote')
        ->add('medidapote', 
                ChoiceType::class, array(
                'choices'   => GlobalValue::MEDIDA_POTE_SELECT,
                'required'  => true,
                'label'=>'Medida Pote:'
                )
        )
        ->add('medidapote', 
            ChoiceType::class, array(
            'choices'   => GlobalValue::MEDIDA_HELADO_SELECT,
            'required'  => true,
            'label'=>'Cantidad:')
);



    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Pedidodetalle'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_pedidodetalle';
    }


}
