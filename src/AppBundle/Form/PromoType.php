<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class PromoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre')
                ->add('descripcion',TextareaType::class,['label'=>'Descripcion: ' ])
                ->add('enabled', null,['label'=>'Activado: ' ] )
                ->add('cantidadpotecuarto',     NumberType::class,['label'=>'Cant. Pote 1/4 kg: ','required'=>false ])
                ->add('cantidadpotemedio',      NumberType::class,['label'=>'Cant. Pote 1/2 kg: ','required'=>false ])
                ->add('cantidadpotetrescuarto', NumberType::class,['label'=>'Cant. Pote 3/4 kg: ','required'=>false ])
                ->add('cantidadpotekilo',       NumberType::class,['label'=>'Cant. Pote 1   kg: ','required'=>false ])
                ->add('importedescuento',       NumberType::class, ['label'=>'Importe Descuento: ', ])
                ->add('preciopromo',            NumberType::class, ['label'=>'Precio Promo: ' ])
                ->add('precioanterior',         NumberType::class, ['label'=>'Precio Anterior: ' ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Promo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_promo';
    }


}
