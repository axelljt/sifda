<?php

namespace Minsal\sifdaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Minsal\sifdaBundle\Entity\SifdaSolicitudServicio;
use Minsal\sifdaBundle\Form\SifdaSolicitudServicioType;

/**
 * SifdaSolicitudServicio controller.
 *
 * @Route("/sifda/solicitudservicio")
 */
class SifdaSolicitudServicioController extends Controller
{

    /**
     * Lists all SifdaSolicitudServicio entities.
     *
     * @Route("/", name="sifda_solicitudservicio")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MinsalsifdaBundle:SifdaSolicitudServicio')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    
    /**
    * Ajax utilizado para buscar rango de fechas
    *  
    * @Route("/buscarSolicitudes", name="sifda_solicitudservicio_buscar_solicitudes")
    */
    public function buscarSolicitudesAction()
    {
        $isAjax = $this->get('Request')->isXMLhttpRequest();
        if($isAjax){
             $fechaInicio = $this->get('request')->request->get('fechaInicio');
             $fechaFin = $this->get('request')->request->get('fechaFin');
             $em = $this->getDoctrine()->getManager();
             $solicitudes = $em->getRepository('MinsalsifdaBundle:SifdaSolicitudServicio')->FechaSolicitud($fechaInicio, $fechaFin);
             $mensaje = $this->renderView('MinsalsifdaBundle:SifdaSolicitudServicio:solicitudesShow.html.twig' , array('solicitudes' =>$solicitudes));
             $response = new JsonResponse();
             return $response->setData($mensaje);
        }else
            {   return new Response('0');   }       
    }    
    
    
    /**
     * Creates a new SifdaSolicitudServicio entity.
     *
     * @Route("/", name="sifda_solicitudservicio_create")
     * @Method("POST")
     * @Template("MinsalsifdaBundle:SifdaSolicitudServicio:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new SifdaSolicitudServicio();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('sifda_solicitudservicio_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a SifdaSolicitudServicio entity.
     *
     * @param SifdaSolicitudServicio $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SifdaSolicitudServicio $entity)
    {
        $form = $this->createForm(new SifdaSolicitudServicioType(), $entity, array(
            'action' => $this->generateUrl('sifda_solicitudservicio_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new SifdaSolicitudServicio entity.
     *
     * @Route("/new", name="sifda_solicitudservicio_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new SifdaSolicitudServicio();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a SifdaSolicitudServicio entity.
     *
     * @Route("/{id}", name="sifda_solicitudservicio_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MinsalsifdaBundle:SifdaSolicitudServicio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SifdaSolicitudServicio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SifdaSolicitudServicio entity.
     *
     * @Route("/{id}/edit", name="sifda_solicitudservicio_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MinsalsifdaBundle:SifdaSolicitudServicio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SifdaSolicitudServicio entity.');
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
    * Creates a form to edit a SifdaSolicitudServicio entity.
    *
    * @param SifdaSolicitudServicio $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(SifdaSolicitudServicio $entity)
    {
        $form = $this->createForm(new SifdaSolicitudServicioType(), $entity, array(
            'action' => $this->generateUrl('sifda_solicitudservicio_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing SifdaSolicitudServicio entity.
     *
     * @Route("/{id}", name="sifda_solicitudservicio_update")
     * @Method("PUT")
     * @Template("MinsalsifdaBundle:SifdaSolicitudServicio:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MinsalsifdaBundle:SifdaSolicitudServicio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SifdaSolicitudServicio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('sifda_solicitudservicio_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a SifdaSolicitudServicio entity.
     *
     * @Route("/{id}", name="sifda_solicitudservicio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MinsalsifdaBundle:SifdaSolicitudServicio')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SifdaSolicitudServicio entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('sifda_solicitudservicio'));
    }

    /**
     * Creates a form to delete a SifdaSolicitudServicio entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sifda_solicitudservicio_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
