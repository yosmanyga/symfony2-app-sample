<?php

namespace Claudia\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrarDistribucion2Type extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lote', 'entity', array(
                'class' => 'Claudia\AppBundle\Entity\Lote',
                'expanded' => true
            ))
            ->add('unidad', 'entity', array(
                'class' => 'Claudia\AppBundle\Entity\Unidad',
                'empty_value' => 'Seleccione la unidad',
            ))
            ->add('cant')
            ->add('fechaEntrada', 'date');
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