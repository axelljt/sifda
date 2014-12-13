<?php

namespace Minsal\sifdaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Minsal\sifdaBundle\Entity\SifdaOrdenTrabajo;
use Minsal\sifdaBundle\Form\SifdaOrdenTrabajoType;

/**
 * SifdaOrdenTrabajo controller.
 *
 * @Route("/sifda/ordentrabajo")
 */
class SifdaOrdenTrabajoController extends Controller
{

    /**
     * Lists all SifdaOrdenTrabajo entities.
     *
     * @Route("/", name="sifda_ordentrabajo")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MinsalsifdaBundle:SifdaOrdenTrabajo')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new SifdaOrdenTrabajo entity.
     *
     * @Route("/", name="sifda_ordentrabajo_create")
     * @Method("POST")
     * @Template("MinsalsifdaBundle:SifdaOrdenTrabajo:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new SifdaOrdenTrabajo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('sifda_ordentrabajo_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a SifdaOrdenTrabajo entity.
     *
     * @param SifdaOrdenTrabajo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SifdaOrdenTrabajo $entity)
    {
        $form = $this->createForm(new SifdaOrdenTrabajoType(), $entity, array(
            'action' => $this->generateUrl('sifda_ordentrabajo_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new SifdaOrdenTrabajo entity.
     *
     * @Route("/new", name="sifda_ordentrabajo_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new SifdaOrdenTrabajo();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a SifdaOrdenTrabajo entity.
     *
     * @Route("/{id}", name="sifda_ordentrabajo_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MinsalsifdaBundle:SifdaOrdenTrabajo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SifdaOrdenTrabajo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SifdaOrdenTrabajo entity.
     *
     * @Route("/{id}/edit", name="sifda_ordentrabajo_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MinsalsifdaBundle:SifdaOrdenTrabajo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SifdaOrdenTrabajo entity.');
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
    * Creates a form to edit a SifdaOrdenTrabajo entity.
    *
    * @param SifdaOrdenTrabajo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(SifdaOrdenTrabajo $entity)
    {
        $form = $this->createForm(new SifdaOrdenTrabajoType(), $entity, array(
            'action' => $this->generateUrl('sifda_ordentrabajo_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing SifdaOrdenTrabajo entity.
     *
     * @Route("/{id}", name="sifda_ordentrabajo_update")
     * @Method("PUT")
     * @Template("MinsalsifdaBundle:SifdaOrdenTrabajo:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MinsalsifdaBundle:SifdaOrdenTrabajo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SifdaOrdenTrabajo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('sifda_ordentrabajo_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a SifdaOrdenTrabajo entity.
     *
     * @Route("/{id}", name="sifda_ordentrabajo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MinsalsifdaBundle:SifdaOrdenTrabajo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SifdaOrdenTrabajo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('sifda_ordentrabajo'));
    }

    /**
     * Creates a form to delete a SifdaOrdenTrabajo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sifda_ordentrabajo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    /**
    * Ajax utilizado para buscar rango de fechas
    *  
    * @Route("/ordentrabajo", name="sifda_ordentrabajo_buscar_ordenes")
    */
    public function buscarOrdenesAction()
    {
        $isAjax = $this->get('Request')->isXMLhttpRequest();
        if($isAjax){
             
            
            $fechaInicio = $this->get('request')->request->get('fechaInicio');
             $fechaFin = $this->get('request')->request->get('fechaFin');
             $em = $this->getDoctrine()->getManager();
             $ordenes = $em->getRepository('MinsalsifdaBundle:SifdaOrdenTrabajo')->buscarOrdenXFecha($fechaInicio, $fechaFin);
//             $ladybug_dump( $ordenes);
             $mensaje = $this->renderView('MinsalsifdaBundle:SifdaOrdenTrabajo:ordenesShow.html.twig' , array('ordenes' =>$ordenes));
             $response = new JsonResponse();
             return $response->setData($mensaje);
        }else
            {   return new Response('0');   }       
    }
}
