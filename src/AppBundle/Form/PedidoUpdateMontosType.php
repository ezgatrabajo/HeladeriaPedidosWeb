<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;




class PedidoUpdateMontosType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cantidadkilos', IntegerType::class,array('label'=>'Kilos (expresado en ml): '))
            ->add('cantidadpotes',IntegerType::class,array('label'=>'Potes: '))
            ->add('cucharitas',IntegerType::class,array('label'=>'Cucharitas: '))
            ->add('cucuruchos',IntegerType::class,array('label'=>'Cucuruchos: '))
            ->add('montocucuruchos',MoneyType::class,array('label'=>'Monto Cucuruchos: '))
            ->add('montohelados',MoneyType::class,array('label'=>'Monto Helados: '))
            ->add('montodescuento',MoneyType::class,array('label'=>'Monto Descuento: '))
            ->add('monto',MoneyType::class,array('label'=>'Monto Total: '))
            ->add('montoabona',MoneyType::class,array('label'=>'Abona Con: '))
            ->add('enviodomicilio', ChoiceType::class, array(
                'choices'  => array(
                    'SI' => true,
                    'NO' => false,
                ),'label'=>'Envio a Domicilio:'))
            
        
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
