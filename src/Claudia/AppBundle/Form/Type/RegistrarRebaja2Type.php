<?php

namespace Claudia\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrarRebaja2Type extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lote', 'entity', array(
                'class' => 'Claudia\AppBundle\Entity\Lote',
            ))
            ->add('unidad', 'entity', array(
                'class' => 'Claudia\AppBundle\Entity\Unidad',
            ))
            ->add('fechaSolicitud', 'date')
            ->add('fechaAprovacion', 'date')
            ->add('observaciones', 'textarea')
            ->add('precioAplicado');
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