<?php

namespace Minsal\sifdaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Minsal\sifdaBundle\Entity\SifdaEquipoTrabajo;
use Minsal\sifdaBundle\Form\SifdaEquipoTrabajoType;

/**
 * SifdaEquipoTrabajo controller.
 *
 * @Route("/sifda/equipotrabajo")
 */
class SifdaEquipoTrabajoController extends Controller
{

    /**
     * Lists all SifdaEquipoTrabajo entities.
     *
     * @Route("/", name="sifda_equipotrabajo")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MinsalsifdaBundle:SifdaEquipoTrabajo')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new SifdaEquipoTrabajo entity.
     *
     * @Route("/create/{id}", name="sifda_equipotrabajo_create")
     * @Method("POST")
     * @Template("MinsalsifdaBundle:SifdaEquipoTrabajo:new.html.twig")
     */
    public function createAction(Request $request, $id)
    {
        $entity = new SifdaEquipoTrabajo();
        $form = $this->createCreateForm($entity, $id);
        
        $em = $this->getDoctrine()->getManager();
        $idOrdenTrabajo = $em->getRepository('MinsalsifdaBundle:SifdaOrdenTrabajo')->find($id);
        $entity->setIdOrdenTrabajo($idOrdenTrabajo);
        $entity->setResponsableEquipo(TRUE);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            $data = $form->get('equipoTrabajo')->getData();
            if($data){
                $this->establecerEquipoTrabajo($idOrdenTrabajo, $data);
            }
            
            return $this->redirect($this->generateUrl('sifda_ordentrabajo_gestion'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a SifdaEquipoTrabajo entity.
     *
     * @param SifdaEquipoTrabajo $entity The entity
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SifdaEquipoTrabajo $entity, $id)
    {
        $form = $this->createForm(new SifdaEquipoTrabajoType(), $entity, array(
            'action' => $this->generateUrl('sifda_equipotrabajo_create', array('id' => $id)),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Registrar personal'));

        return $form;
    }

    /**
     * Displays a form to create a new SifdaEquipoTrabajo entity.
     *
     * @Route("/new/{id}", name="sifda_equipotrabajo_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($id)
    {
        $entity = new SifdaEquipoTrabajo();
        if ($id != 0) {
           $em = $this->getDoctrine()->getManager();
           $orden = $em->getRepository('MinsalsifdaBundle:SifdaOrdenTrabajo')->find($id);
        
           if (!$orden) {
                throw $this->createNotFoundException('Unable to find SifdaOrdenTrabajo entity.');
            }
        }
        
        $empleados = $em->getRepository('MinsalsifdaBundle:CtlEmpleado')->findAll();
        $form   = $this->createCreateForm($entity, $id);

        return array(
            'entity' => $entity,
            'orden' => $orden,
            'empleados' => $empleados,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a SifdaEquipoTrabajo entity.
     *
     * @Route("/{id}", name="sifda_equipotrabajo_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $ordenTrabajo = $em->getRepository('MinsalsifdaBundle:SifdaOrdenTrabajo')->find($id);
        $responsable = $em->getRepository('MinsalsifdaBundle:SifdaEquipoTrabajo')->findOneBy(array(
                                                                            'idOrdenTrabajo' => $ordenTrabajo,
                                                                            'responsableEquipo' => 'TRUE'
                                                                                ));
        /*if (!$responsable) {
            throw $this->createNotFoundException(
                                'No se ha encontrado equipo de trabajo asignado a la orden'
                                );
        }*/
        
        $personal = $em->getRepository('MinsalsifdaBundle:SifdaEquipoTrabajo')->findBy(array(
                                                                            'idOrdenTrabajo' => $ordenTrabajo,
                                                                            'responsableEquipo' => 'FALSE'
                                                                                ));
        
        //$deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'       => $responsable,
            'personal'     => $personal,
            'ordenTrabajo' => $ordenTrabajo,
        //    'delete_form'  => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SifdaEquipoTrabajo entity.
     *
     * @Route("/{id}/edit", name="sifda_equipotrabajo_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MinsalsifdaBundle:SifdaEquipoTrabajo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SifdaEquipoTrabajo entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a SifdaEquipoTrabajo entity.
    *
    * @param SifdaEquipoTrabajo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(SifdaEquipoTrabajo $entity)
    {
        $form = $this->createForm(new SifdaEquipoTrabajoType(), $entity, array(
            'action' => $this->generateUrl('sifda_equipotrabajo_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing SifdaEquipoTrabajo entity.
     *
     * @Route("/{id}", name="sifda_equipotrabajo_update")
     * @Method("PUT")
     * @Template("MinsalsifdaBundle:SifdaEquipoTrabajo:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MinsalsifdaBundle:SifdaEquipoTrabajo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SifdaEquipoTrabajo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('sifda_equipotrabajo_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a SifdaEquipoTrabajo entity.
     *
     * @Route("/{id}", name="sifda_equipotrabajo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MinsalsifdaBundle:SifdaEquipoTrabajo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SifdaEquipoTrabajo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('sifda_equipotrabajo'));
    }

    /**
     * Creates a form to delete a SifdaEquipoTrabajo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sifda_equipotrabajo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    /**
     * Metodo que sirve para establecer al equipo de trabajo de la orden de trabajo.
     *
     * @param \Minsal\sifdaBundle\Entity\SifdaOrdenTrabajo $idOrdenTrabajo
     * @param \Doctrine\Common\Collections\ArrayCollection $personal
     *
     */
    private function establecerEquipoTrabajo(\Minsal\sifdaBundle\Entity\SifdaOrdenTrabajo $idOrdenTrabajo,
                                             \Doctrine\Common\Collections\ArrayCollection $personal)
    {
        foreach ($personal as $idEmpleado)
        {
            $entity = new SifdaEquipoTrabajo();
            $entity->setIdOrdenTrabajo($idOrdenTrabajo);
            $entity->setResponsableEquipo(FALSE);
            $entity->setIdEmpleado($idEmpleado);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }    
    }
}