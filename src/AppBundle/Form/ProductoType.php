<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProductoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    protected $empresa;
    public function getEmpresa(){
        return $this->empresa;
    }
    public function setEmpresa($empresa){
        $this->empresa = $empresa;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre')
                ->add('descripcion', TextareaType::class)
                ->add('enabled', ChoiceType::class, array(
                        'choices'  => array(
                            'SI' => true,
                            'NO' => false,
                    ),'label'=>'Disponible'))
                ->add('codigoexterno', null, array('required'=>false))
                ->add('imagen', FileType::class, array('data_class' => null, 'required'=>false));;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Producto'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_producto';
    }


}
