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
     * Lists all SifdaOrdenTrabajo entities.
     *
     * @Route("/gestion_ordenestrabajo", name="sifda_ordentrabajo_gestion")
     * @Method("GET")
     * @Template()
     */
    public function gestionOrdenesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MinsalsifdaBundle:SifdaOrdenTrabajo')->findBy(array(),
                                                                                       array(
                                                                                'fechaCreacion' =>  'DESC'
                                                                               ));
        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new SifdaOrdenTrabajo entity.
     *
     * @Route("/create/{id}", name="sifda_ordentrabajo_create")
     * @Method("POST")
     * @Template("MinsalsifdaBundle:SifdaOrdenTrabajo:new.html.twig")
     */
     
        public function createAction(Request $request, $id)
    {
        $entity = new SifdaOrdenTrabajo();
        $form = $this->createCreateForm($entity, $id);
        
        $em = $this->getDoctrine()->getManager();
        
        //Obtener la solicitud de servicio que se va a atender
        $idSolicitudServicio = $em->getRepository('MinsalsifdaBundle:SifdaSolicitudServicio')->find($id);
        $entity->setIdSolicitudServicio($idSolicitudServicio);
        
        $form->handleRequest($request);
        
        //Obtener la dependencia y establecimiento de la orden de trabajo
        $establecimiento = $form->get('establecimiento')->getData();
        $dependencia = $form->get('dependencia')->getData();
        $idDependenciaEstablecimiento = $em->getRepository('MinsalsifdaBundle:CtlDependenciaEstablecimiento')->findOneBy(array(
                                                           'idEstablecimiento' => $establecimiento,
                                                           'idDependencia' => $dependencia         
                                                            ));
        
        if (!$idDependenciaEstablecimiento) {
            throw $this->createNotFoundException('Unable to find CtlDependenciaEstablecimiento entity.');
        }
        $entity->setIdDependenciaEstablecimiento($idDependenciaEstablecimiento);
        
        $idEstado = $em->getRepository('MinsalsifdaBundle:CatalogoDetalle')->findOneBy(array(
                                                            'descripcion'=>'Asignado'
                                                            ));
        
        
        //Generar el codigo que se le asignara a la orden de trabajo
        $codigo = $this->generarCodigoOrden($idDependenciaEstablecimiento);
        $entity->setCodigo($codigo);
        
        if ($form->isValid()) {
            $entity->setFechaCreacion(new \DateTime("now"));
            $entity->setIdEstado($idEstado);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            $estado = $idSolicitudServicio->getIdEstado()->getId();
            if($estado==1)
            {
                $objEstado = $em->getRepository('MinsalsifdaBundle:CatalogoDetalle')->find(2);
                $idSolicitudServicio->setIdEstado($objEstado);
                $em->merge($idSolicitudServicio);
                $em->flush();
            }   
            
            return $this->redirect($this->generateUrl('sifda_ordentrabajo_gestion'));
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
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SifdaOrdenTrabajo $entity, $id)
    {
        $form = $this->createForm(new SifdaOrdenTrabajoType(), $entity, array(
            'action' => $this->generateUrl('sifda_ordentrabajo_create', array('id' => $id)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear orden de trabajo'));

        return $form;
    }

    /**
     * Displays a form to create a new SifdaOrdenTrabajo entity.
     *
     * @Route("/new{id}", name="sifda_ordentrabajo_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($id)
    {
         $entity = new SifdaOrdenTrabajo();
        if ($id != 0) {
           $em = $this->getDoctrine()->getManager();
           $solicitud = $em->getRepository('MinsalsifdaBundle:SifdaSolicitudServicio')->find($id);
        
           if (!$solicitud) {
                throw $this->createNotFoundException('Unable to find SifdaOrdenTrabajo entity.');
            }
            
        }
        
        $empleados = $em->getRepository('MinsalsifdaBundle:CtlEmpleado')->findAll();
        $form   = $this->createCreateForm($entity, $id);

        return array(
            'entity' => $entity,
            'solicitud' => $solicitud,
            'empleados' => $empleados,
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
        $editForm->get('establecimiento')->setData($entity
                                                    ->getIdDependenciaEstablecimiento()
                                                    ->getIdEstablecimiento()
                                                   );
        $editForm->get('dependencia')->setData($entity
                                                ->getIdDependenciaEstablecimiento()
                                                ->getIdDependencia()
                                               );
        //$deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            //'delete_form' => $deleteForm->createView(),
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

        $form->add('submit', 'submit', array('label' => 'Modificar'));

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
        
        //Obtener la dependencia y establecimiento de la orden de trabajo
        $establecimiento = $editForm->get('establecimiento')->getData();
        $dependencia = $editForm->get('dependencia')->getData();
        $idDependenciaEstablecimiento = $em->getRepository('MinsalsifdaBundle:CtlDependenciaEstablecimiento')->findOneBy(array(
                                                           'idEstablecimiento' => $establecimiento,
                                                           'idDependencia' => $dependencia         
                                                            ));
        
        if (!$idDependenciaEstablecimiento) {
            throw $this->createNotFoundException('Unable to find CtlDependenciaEstablecimiento entity.');
        }
        $entity->setIdDependenciaEstablecimiento($idDependenciaEstablecimiento);
        
        
        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('sifda_ordentrabajo_gestion'));
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
            ->add('submit', 'submit', array('label' => 'Eliminar'))
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

    /** 
     * Metodo que sirve para generar el codigo de la orden de trabajo
     * 
     * @param \Minsal\sifdaBundle\Entity\CtlDependenciaEstablecimiento $idDependenciaEstablecimiento
     * 
     * @return string
     */
    public function generarCodigoOrden(\Minsal\sifdaBundle\Entity\CtlDependenciaEstablecimiento $idDependenciaEstablecimiento) 
    {
        $codigo = "";
        $dependencia = $idDependenciaEstablecimiento->getIdDependencia()->getNombre();
        $establecimiento = $idDependenciaEstablecimiento->getIdEstablecimiento()->getNombre();
        
        $codigo.= substr($establecimiento, 0, 3);
        $codigo.= substr($dependencia, 0, 2);
        $codigo = strtoupper($codigo);        
        
        $fechaActual = new \DateTime();
        $dql = "SELECT count(u.codigo) cantidad
			  FROM MinsalsifdaBundle:SifdaOrdenTrabajo u
			  WHERE u.codigo LIKE :codigo";
                  
        $em = $this->getDoctrine()->getManager();
        $cantidadCodigos= $em->createQuery($dql)
                             ->setParameter(':codigo', $codigo.'___'.$fechaActual->format('y'))
                             ->getResult();
        $cantidad = $cantidadCodigos[0]['cantidad'] + 1;
        
        switch ($cantidad){
            case ($cantidad < 10):
                $codigo.= "00".$cantidad;
                break;
            case ($cantidad >= 10 and $cantidad < 100):
                $codigo.= "0".$cantidad;
                break;
            default:
                $codigo.= $cantidad;
                break;
        }
        
        $codigo.= $fechaActual->format('y');
        
        return $codigo;
    }
}
