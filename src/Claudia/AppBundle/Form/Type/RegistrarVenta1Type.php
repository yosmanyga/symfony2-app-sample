<?php

namespace Claudia\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrarVenta1Type extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('producto', 'entity', array(
            'class' => 'Claudia\AppBundle\Entity\Producto',
            'empty_value' => 'Seleccione un producto',
        ));
        $builder->add('unidad', 'entity', array(
            'class' => 'Claudia\AppBundle\Entity\Unidad',
            'empty_value' => 'Seleccione una unidad',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return '';
    }
}