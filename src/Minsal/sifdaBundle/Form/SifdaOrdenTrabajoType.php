<?php

namespace Minsal\sifdaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SifdaOrdenTrabajoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion')
            ->add('codigo')
            ->add('fechaCreacion')
            ->add('fechaFinalizacion')
            ->add('observacion')
            ->add('idPrioridad')
            ->add('idEstado')
            ->add('idDependenciaEstablecimiento')
            ->add('idEtapa')
            ->add('idSolicitudServicio')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Minsal\sifdaBundle\Entity\SifdaOrdenTrabajo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'minsal_sifdabundle_sifdaordentrabajo';
    }
}
