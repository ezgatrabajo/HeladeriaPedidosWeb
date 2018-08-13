<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use AppBundle\Entity\GlobalValue;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class HorarioType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dia', 
                ChoiceType::class, array(
                'choices'   => GlobalValue::DIAS_SEMANA_SELECT,
                'required'  => true,
                'label'=>'Dia:'
                ))
            ->add('apertura')
            ->add('cierre')
            ->add('observaciones');

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Horario'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_horario';
    }


}
