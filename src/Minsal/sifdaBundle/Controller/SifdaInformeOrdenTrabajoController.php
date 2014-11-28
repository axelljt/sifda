<?php

namespace Minsal\sifdaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Minsal\sifdaBundle\Entity\SifdaInformeOrdenTrabajo;
use Minsal\sifdaBundle\Form\SifdaInformeOrdenTrabajoType;

/**
 * SifdaInformeOrdenTrabajo controller.
 *
 * @Route("/sifda/sifdainformeordentrabajo")
 */
class SifdaInformeOrdenTrabajoController extends Controller
{

    /**
     * Lists all SifdaInformeOrdenTrabajo entities.
     *
     * @Route("/", name="sifdainformeordentrabajo")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MinsalsifdaBundle:SifdaInformeOrdenTrabajo')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new SifdaInformeOrdenTrabajo entity.
     *
     * @Route("/", name="sifdainformeordentrabajo_create")
     * @Method("POST")
     * @Template("MinsalsifdaBundle:SifdaInformeOrdenTrabajo:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new SifdaInformeOrdenTrabajo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('sifdainformeordentrabajo_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a SifdaInformeOrdenTrabajo entity.
     *
     * @param SifdaInformeOrdenTrabajo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SifdaInformeOrdenTrabajo $entity)
    {
        $form = $this->createForm(new SifdaInformeOrdenTrabajoType(), $entity, array(
            'action' => $this->generateUrl('sifdainformeordentrabajo_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new SifdaInformeOrdenTrabajo entity.
     *
     * @Route("/new", name="sifdainformeordentrabajo_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new SifdaInformeOrdenTrabajo();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a SifdaInformeOrdenTrabajo entity.
     *
     * @Route("/{id}", name="sifdainformeordentrabajo_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MinsalsifdaBundle:SifdaInformeOrdenTrabajo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SifdaInformeOrdenTrabajo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SifdaInformeOrdenTrabajo entity.
     *
     * @Route("/{id}/edit", name="sifdainformeordentrabajo_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MinsalsifdaBundle:SifdaInformeOrdenTrabajo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SifdaInformeOrdenTrabajo entity.');
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
    * Creates a form to edit a SifdaInformeOrdenTrabajo entity.
    *
    * @param SifdaInformeOrdenTrabajo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(SifdaInformeOrdenTrabajo $entity)
    {
        $form = $this->createForm(new SifdaInformeOrdenTrabajoType(), $entity, array(
            'action' => $this->generateUrl('sifdainformeordentrabajo_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing SifdaInformeOrdenTrabajo entity.
     *
     * @Route("/{id}", name="sifdainformeordentrabajo_update")
     * @Method("PUT")
     * @Template("MinsalsifdaBundle:SifdaInformeOrdenTrabajo:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MinsalsifdaBundle:SifdaInformeOrdenTrabajo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SifdaInformeOrdenTrabajo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('sifdainformeordentrabajo_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a SifdaInformeOrdenTrabajo entity.
     *
     * @Route("/{id}", name="sifdainformeordentrabajo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MinsalsifdaBundle:SifdaInformeOrdenTrabajo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SifdaInformeOrdenTrabajo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('sifdainformeordentrabajo'));
    }

    /**
     * Creates a form to delete a SifdaInformeOrdenTrabajo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sifdainformeordentrabajo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
