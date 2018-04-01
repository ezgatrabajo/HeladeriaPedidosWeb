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
                ->add('fechadesde',DateType::class, [ 'widget' => 'single_text','label'=>'Fecha Desde: ' ])
                ->add('fechahasta',DateType::class, [ 'widget' => 'single_text','label'=>'Fecha Hasta: '])
                ->add('cantidadkilos',NumberType::class,['label'=>'Cantidad Kilos (Expresado en gramos): ' ])
                ->add('importedescuento',NumberType::class, ['label'=>'Importe Descuento: ' ])
                ->add('preciopromo',NumberType::class, ['label'=>'Precio Promo: ' ])
                ->add('precioanterior',NumberType::class, ['label'=>'Precio Anterior: ' ]);
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
