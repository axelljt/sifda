<?php

namespace Minsal\sifdaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Minsal\sifdaBundle\Entity\SifdaRutaCicloVida;
use Minsal\sifdaBundle\Entity\SifdaRuta;
use Minsal\sifdaBundle\Form\SifdaRutaCicloVidaType;

/**
 * SifdaRutaCicloVida controller.
 *
 * @Route("/sifda/rutaciclovida")
 */
class SifdaRutaCicloVidaController extends Controller
{

    /**
     * Lists all SifdaRutaCicloVida entities.
     *
     * @Route("/", name="sifda_rutaciclovida")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MinsalsifdaBundle:SifdaRutaCicloVida')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new SifdaRutaCicloVida entity.
     *
     * @Route("/", name="sifda_rutaciclovida_create")
     * @Method("POST")
     * @Template("MinsalsifdaBundle:SifdaRutaCicloVida:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new SifdaRutaCicloVida();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('sifdatiposervicio_show', 
                                                       array('id' => $entity->getIdRuta()
                                                                            ->getIdTipoServicio()
                                                                            ->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new SifdaRutaCicloVida entity.
     *
     * @Route("/", name="sifda_subetapa_create")
     * @Method("POST")
     * @Template("MinsalsifdaBundle:SifdaRutaCicloVida:new.html.twig")
     */
    public function createSubetapaAction(Request $request)
    {
        $entity = new SifdaRutaCicloVida();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('sifda_rutaciclovida_show', 
                                                       array('id' => $entity->getIdEtapa()->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    
    /**
     * Creates a form to create a SifdaRutaCicloVida entity.
     *
     * @param SifdaRutaCicloVida $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SifdaRutaCicloVida $entity)
    {
        $form = $this->createForm(new SifdaRutaCicloVidaType(), $entity, array(
            'action' => $this->generateUrl('sifda_rutaciclovida_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Registrar'));

        return $form;
    }

    /**
     * Creates a form to create a SifdaRutaCicloVida entity.
     *
     * @param SifdaRutaCicloVida $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateFormSubetapa(SifdaRutaCicloVida $entity)
    {
        $form = $this->createForm(new SifdaRutaCicloVidaType(), $entity, array(
            'action' => $this->generateUrl('sifda_subetapa_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Registrar'));

        return $form;
    }
    
    /**
     * Displays a form to create a new SifdaRutaCicloVida entity.
     *
     * @Route("/new/{id}", name="sifda_rutaciclovida_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($id)
    {
        $entity = new SifdaRutaCicloVida();
        if ($id != 0) {
           $em = $this->getDoctrine()->getManager();
           $tipo = $em->getRepository('MinsalsifdaBundle:SifdaTipoServicio')->find($id);
        }    
        $form   = $this->createCreateForm($entity);
        
        return array(
            'entity' => $entity,
            'tipo' => $tipo,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new SifdaRutaCicloVida entity.
     *
     * @Route("/new_subetapa/{id}", name="sifda_rutaciclovida_new_subetapa")
     * @Method("GET")
     * @Template()
     */
    public function newSubetapaAction($id)
    {
        $entity = new SifdaRutaCicloVida();
        if ($id != 0) {
           $em = $this->getDoctrine()->getManager();
           $etapa = $em->getRepository('MinsalsifdaBundle:SifdaRutaCicloVida')->find($id);
        }    
        $form   = $this->createCreateFormSubetapa($entity);
        
        return array(
            'entity' => $entity,
            'etapa' => $etapa,
            'form'   => $form->createView(),
        );
    }
    
    /**
     * Finds and displays a SifdaRutaCicloVida entity.
     *
     * @Route("/{id}", name="sifda_rutaciclovida_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MinsalsifdaBundle:SifdaRutaCicloVida')->find($id);
        $subetapas = $em->getRepository('MinsalsifdaBundle:SifdaRutaCicloVida')->obtenerSubetapas($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SifdaRutaCicloVida entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'subetapas' => $subetapas,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SifdaRutaCicloVida entity.
     *
     * @Route("/{id}/edit", name="sifda_rutaciclovida_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MinsalsifdaBundle:SifdaRutaCicloVida')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SifdaRutaCicloVida entity.');
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
    * Creates a form to edit a SifdaRutaCicloVida entity.
    *
    * @param SifdaRutaCicloVida $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(SifdaRutaCicloVida $entity)
    {
        $form = $this->createForm(new SifdaRutaCicloVidaType(), $entity, array(
            'action' => $this->generateUrl('sifda_rutaciclovida_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing SifdaRutaCicloVida entity.
     *
     * @Route("/{id}", name="sifda_rutaciclovida_update")
     * @Method("PUT")
     * @Template("MinsalsifdaBundle:SifdaRutaCicloVida:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MinsalsifdaBundle:SifdaRutaCicloVida')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SifdaRutaCicloVida entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('sifda_rutaciclovida_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a SifdaRutaCicloVida entity.
     *
     * @Route("/{id}", name="sifda_rutaciclovida_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MinsalsifdaBundle:SifdaRutaCicloVida')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SifdaRutaCicloVida entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('sifda_rutaciclovida'));
    }

    /**
     * Creates a form to delete a SifdaRutaCicloVida entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sifda_rutaciclovida_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
