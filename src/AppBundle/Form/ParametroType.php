<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class ParametroType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre',       TextType::class, ['label'=>'Nombre: ' ])
                ->add('descripcion',  TextareaType::class,[ 'label'=>'Descripcion: ' ])
                ->add('valorTexto',   TextType::class, ['label'=>'Valor Texto: ','required'=>false ] )
                ->add('valorInteger', NumberType::class, ['label'=>'Valor Numero Entero: ','required'=>false ] )
                ->add('valorDecimal', MoneyType::class, ['label'=>'Valor Numero Decimal: ','required'=>false ])
                ->add('valorFecha',   DateType::class, [ 'widget' => 'single_text','label'=>'Valor Fecha: ','required'=>false ]);
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Parametro'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_parametro';
    }


}
