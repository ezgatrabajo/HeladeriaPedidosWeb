<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Entity\GlobalValue;

class PedidoChangeStatusType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tiempodemora', ChoiceType::class, array(
                'choices'   => GlobalValue::TIEMPO_DEMORA_SELECT,
                'required'  => true,
                'label'=>'Tiempo de Demora:'))
            ->add('estadoid', ChoiceType::class, array(
                'choices'   => GlobalValue::ESTADOS_SELECT,
                'required'  => true,
                'label'=>'Cambiar a Estado: '))
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
