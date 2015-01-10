<?php

namespace Minsal\sifdaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SifdaInformeOrdenTrabajoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('detalle')
            ->add('fechaRealizacion','date',array('input'=>'datetime','widget'=>'single_text',
                  'format'=>'yyyy-MM-dd','attr'=>array('class'=>'date')))
            ->add('fechaRegistro','date',array('input'=>'datetime','widget'=>'single_text',
                  'format'=>'yyyy-MM-dd','attr'=>array('class'=>'date'))) 
//            ->add('terminado')
            ->add('idDependenciaEstablecimiento')
            ->add('idEmpleado')
            ->add('idOrdenTrabajo')    
            ->add('idEtapa')
            ->add('idSubactividad')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Minsal\sifdaBundle\Entity\SifdaInformeOrdenTrabajo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'minsal_sifdabundle_sifdainformeordentrabajo';
    }
}
