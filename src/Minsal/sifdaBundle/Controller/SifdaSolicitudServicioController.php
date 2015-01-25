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

        $estado=1;
        $em = $this->getDoctrine()->getManager();
        
         $solicitudes = $em->getRepository('MinsalsifdaBundle:SifdaSolicitudServicio')->ContarSolicitudesIngresadas($estado);
//         $solicitudes2=  implode("",$solicitudes);
//         ladybug_dump($solicitudes);
         if(!$solicitudes)
             {
                throw $this->createNotFoundException('Unable to find SifdaSolicitudServicio entity.');
             }
            
                     
       $valor=  array_shift($solicitudes);
             
        return array(
            'entities' => $entities,
            'dependencias'=>$valor
        );
    }
    
        /**
     * Lists all SifdaSolicitudServicio entities.
     *
     * @Route("/gestion_solicitudes", name="sifda_gestionSolicitudes")
     * @Method("GET")
     * @Template()
     */
    public function gestionSolicitudesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $objEstado1 = $em->getRepository('MinsalsifdaBundle:CatalogoDetalle')->find(1);
        $ingresados = $em->getRepository('MinsalsifdaBundle:SifdaSolicitudServicio')->findBy(array(
                                                                                    'idEstado' => $objEstado1
                                                                                ),
                                                                                   array('fechaRecepcion' => 'DESC')
                                                                                );
        
        $objEstado2 = $em->getRepository('MinsalsifdaBundle:CatalogoDetalle')->find(3);
        $rechazados = $em->getRepository('MinsalsifdaBundle:SifdaSolicitudServicio')->findBy(array(
                                                                                    'idEstado' => $objEstado2
                                                                                ),
                                                                                    array('fechaRecepcion' => 'DESC')
                                                                                );
       
        $objEstado3 = $em->getRepository('MinsalsifdaBundle:CatalogoDetalle')->find(2);
        $asignados = $em->getRepository('MinsalsifdaBundle:SifdaSolicitudServicio')->findBy(array(
                                                                                    'idEstado' => $objEstado3
                                                                                ),
                                                                                    array('fechaRecepcion' => 'DESC')
                                                                                );
        $obCatalogo = $em->getRepository('MinsalsifdaBundle:Catalogo')->find(2);
        $Estados= $em->getRepository('MinsalsifdaBundle:CatalogoDetalle')->findBy(array(
            'idCatalogo'=> $obCatalogo
        ));
        
        return array(
            'entities' => $ingresados,
            'rechazados'=>$rechazados,
            'asignados'=>$asignados,
            'estados'=> $Estados,
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
    * Ajax utilizado para buscar rango de fechas
    *  
    * @Route("/buscarSolicitudesIngresadas", name="sifda_solicitudservicio_buscar_solicitudes_ingresadas")
    */
    public function buscarSolicitudesIngresadasAction()
    {
        $isAjax = $this->get('Request')->isXMLhttpRequest();
        if($isAjax){
             $fechaInicio = $this->get('request')->request->get('fechaInicio');
             $fechaFin = $this->get('request')->request->get('fechaFin');
             $em = $this->getDoctrine()->getManager();
             $solicitudes = $em->getRepository('MinsalsifdaBundle:SifdaSolicitudServicio')->FechaSolicitudIngresada($fechaInicio, $fechaFin);
             $mensaje = $this->renderView('MinsalsifdaBundle:SifdaSolicitudServicio:solicitudesIngShow.html.twig' , array('solicitudes' =>$solicitudes));
             $response = new JsonResponse();
             return $response->setData($mensaje);
        }else
            {   return new Response('0');   }       
    }   
    
     /**
    * Ajax utilizado para buscar rango de fechas
    *  
    * @Route("/buscarSolicitudes2", name="sifda_solicitudservicio_buscar2_solicitudes")
    */
    public function buscarSolicitudesRechazadasAction()
    {
        $isAjax = $this->get('Request')->isXMLhttpRequest();
        if($isAjax){
             $fechaInicio = $this->get('request')->request->get('fechaInicio');
             $fechaFin = $this->get('request')->request->get('fechaFin');
             $em = $this->getDoctrine()->getManager();
             $solicitudes = $em->getRepository('MinsalsifdaBundle:SifdaSolicitudServicio')->FechaSolicitudRechazadas($fechaInicio, $fechaFin);
             $mensaje = $this->renderView('MinsalsifdaBundle:SifdaSolicitudServicio:solicitudesRechShow.html.twig' , array('solicitudes' =>$solicitudes));
             $response = new JsonResponse();
             return $response->setData($mensaje);
        }else
            {   return new Response('0');   }       
    }    
    
    
       /**
    * Ajax utilizado para buscar rango de fechas
    *  
    * @Route("/buscarSolicitudes3", name="sifda_solicitudservicio_buscar3_solicitudes")
    */
    public function buscarSolicitudesAsignadasAction()
    {
        $isAjax = $this->get('Request')->isXMLhttpRequest();
        if($isAjax){
             $fechaInicio = $this->get('request')->request->get('fechaInicio');
             $fechaFin = $this->get('request')->request->get('fechaFin');
             $em = $this->getDoctrine()->getManager();
             $solicitudes = $em->getRepository('MinsalsifdaBundle:SifdaSolicitudServicio')->FechaSolicitudAsignadas($fechaInicio, $fechaFin);
             $mensaje = $this->renderView('MinsalsifdaBundle:SifdaSolicitudServicio:solicitudesAsigShow.html.twig' , array('solicitudes' =>$solicitudes));
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
        $em = $this->getDoctrine()->getManager();
        $entity = new SifdaSolicitudServicio();
        $form = $this->createCreateForm($entity);
        
        $idEstado = $em->getRepository('MinsalsifdaBundle:CatalogoDetalle')->findOneBy(array('descripcion'=>'Ingresado'));
        $idMedioSolicita = $em->getRepository('MinsalsifdaBundle:CatalogoDetalle')->findOneBy(array('descripcion'=>'Sistema'));
        $idUser = $em->getRepository('MinsalsifdaBundle:FosUserUser')->findOneBy(array('username'=>'anthony'));
        $entity->setIdEstado($idEstado);
        $entity->setIdMedioSolicita($idMedioSolicita);
        $entity->setUser($idUser);
        $entity->setFechaRecepcion(new \DateTime());
        $form->handleRequest($request);
        $validator = $this->get('validator');
        $errors = $validator->validate($entity);
        if ($form->isValid() and count($errors)<=0) {
            $em->persist($entity);
            $em->flush();

//            return $this->redirect($this->generateUrl('sifda_solicitudservicio_show', array('id' => $entity->getId())));
              return $this->redirect($this->generateUrl('sifda_solicitudservicio', array('id' => $entity->getId()))); 
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'errors' => $errors
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

        $form->add('submit', 'submit', array('label' => 'Guardar'));
        
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
            'errors' => null
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
    
    /* Controlador con ComboBox */
    
    
    
    /*Fin de Controlador con ComboBox*/
    
    /**
     * Controlador para la busqueda de Estados.
     *
     * @Route("/showestado/{id}", name="sifda_solicitudservicio_show_estado")
     * @Method("GET")
     * @Template()
     */
    public function showEstadoAction($id)
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
    
    
    /*Controlador que permite recuperar la informacion de un objeto especifico de la bd*/
    
    /**
     * Controlador para la busqueda de Estados.
     *
     * @Route("/buscar_estado/{id}", name="sifda_solicitudservicio_buscar_estado")
     * @Method("GET")
     * @Template()
     */
    public function BuscarEstadoAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MinsalsifdaBundle:SifdaSolicitudServicio')->find($id);
        $dependencia=$em->getRepository('MinsalsifdaBundle:CtlDependencia')->findBy(array('id'=>$id));
        //ladybug_dump($dependencia);

        if (!$entity) {
            throw $this->createNotFoundException('Solicitud de Servicio con id: '.$id.'No encontrado');
        }

//        $deleteForm = $this->createDeleteForm($id);
        
          $estado=$entity->getIdEstado();
          
          
          if($estado == "Ingresado")
          
              return $this->render('MinsalsifdaBundle:SifdaSolicitudServicio:showEstado2.html.twig' , array('entity' =>$entity, 'dependencia'=>$dependencia));


          elseif($estado == "Asignado")
                return $this->render('MinsalsifdaBundle:SifdaSolicitudServicio:showEstado3.html.twig' , array('entity' =>$entity, 'dependencia'=>$dependencia));
          
          elseif($estado == "Rechazado")
                return $this->render('MinsalsifdaBundle:SifdaSolicitudServicio:showEstado4.html.twig' , array('entity' =>$entity, 'dependencia'=>$dependencia));
          
          elseif($estado == "Finalizado")
                return $this->render('MinsalsifdaBundle:SifdaSolicitudServicio:showEstado5.html.twig' , array('entity' =>$entity, 'dependencia'=>$dependencia));

    }
    
    
    /*Fin de la prueba recuperar estado*/

    
    /*Controlador que permite recuperar el nombre de la dependencia*/
    /**
     * Controlador para la busqueda de Estados.
     *
     * @Route("/buscar_dependencia1/{id}", name="sifda_solicitudservicio_buscar_dependencia1")
     * @Method("GET")
     * @Template()
     */
    
    public function GetDependenciasAction($id){
        
        $em = $this->getDoctrine()->getManager();
        
        $dependencia=$em->getRepository('MinsalsifdaBundle:CtlDependencia')->findBy(array('id'=>$id));
        ladybug_dump($dependencia);
        if(!$dependencia){
            return $this->render('MinsalsifdaBundle:Default:index.html.twig',array('dependencia'=>0));
            //throw $this->createNotFoundException('Unable to find SifdaSolicitudServicio entity');
        }
            
        return $this->render('MinsalsifdaBundle:Default:index.html.twig',array('dependencia'=>$dependencia));
        
        }
        
     /*controlador que permite recuperar cuantas solicitudes estan Ingresados
     * @Route("/contar_dependencia", name="sifda_solicitudservicio_contar_dependencia")
     * @Method("GET")
     * @Template()
     */
        
    public function GetNumeroSolicitudesIngresadas()
     {
        $estado="Ingresado";
        $em = $this->getDoctrine()->getManager();
        
         $solicitudes = $em->getRepository('MinsalsifdaBundle:SifdaSolicitudServicio')->ContarSolicitudesIngresadas($estado);
         
         if(!$solicitudes)
             {
                throw $this->createNotFoundException('Unable to find SifdaSolicitudServicio entity.');
             }
          return $this->render('MinsalsifdaBundle:Default:index.html.twig',array('dependencia'=>$solicitudes));   
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

//            return $this->redirect($this->generateUrl('sifda_solicitudservicio_edit', array('id' => $id)));
            return $this->redirect($this->generateUrl('sifda_solicitudservicio', array('id' => $id)));
            
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
     * Deletes a SifdaSolicitudServicio entity.
     *
     * @Route("/delete/{id}", name="sifda_solicitudservicio_delete2")
      * @Method("GET")
     */
    
    
    public function delete2Action($id){
        
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MinsalsifdaBundle:SifdaSolicitudServicio')->find($id);
        

        
        if (!$entity) {
                throw $this->createNotFoundException('Unable to find SifdaSolicitudServicio entity.');
            }

            $em->remove($entity);
            $em->flush();
        
            return $this->redirect($this->generateUrl('sifda_solicitudservicio'));
    }
    
    
    /**
    * Ajax utilizado para buscar rango de fechas
    *  
    * @Route("/sifda/rechazar", name="sifda_solicitudservicio_rechazar")
    */
    
    
    public function rechazarAction(){
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();
        if($isAjax){
            
            $id = $this->get('request')->request->get('id');
        
        $res=0;
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MinsalsifdaBundle:SifdaSolicitudServicio')->find($id);
         
        if (!$entity) {
                throw $this->createNotFoundException('No encontre la Entidad.');
            }

            $estado=$entity->getIdEstado()->getId();
            if($estado==1)
            {
                $objEstado = $em->getRepository('MinsalsifdaBundle:CatalogoDetalle')->find(3);   
            if (!$objEstado) {
                throw $this->createNotFoundException('No encontre el Estado.');
            }
                
                $entity->setIdEstado($objEstado);
                $em->merge($entity);
                $em->flush();
                
                $res=$estado;
//                  return $this->render('MinsalsifdaBundle:SifdaSolicitudServicio:rechazarSolicitudes.html.twig' , array('entity' =>$entity,'val'=>$res));
                    //return $this->redirect($this->generateUrl('sifda_gestionSolicitudes'));
                    
                return new Response('1');
                  
            }     
            
         else 
             {
                $res=$estado;
//                return $this->render('MinsalsifdaBundle:SifdaSolicitudServicio:rechazarSolicitudes.html.twig' , array('entity' =>$entity,'val'=>$res));
//                return new Response('0');
             } 
//                throw $this->createNotFoundException('No pude rechazar la solicitud.');
        }    
            
    } 
    
        /**
    * Ajax utilizado para cambiar el estado de la solicitud de servicio
    *  
    * @Route("/sifda/aceptar", name="sifda_solicitudservicio_aceptar")
    */
    
    
    public function aceptarSolicitudAction(){
        $isAjax = $this->get('Request')->isXMLhttpRequest();
        if($isAjax){
            
        $id = $this->get('request')->request->get('id');
        //ladybug_dump($id);
        $em = $this->getDoctrine()->getManager();
        $rechazados = $em->getRepository('MinsalsifdaBundle:SifdaSolicitudServicio')->find($id);
        
        if (!$rechazados) {
                throw $this->createNotFoundException('No encontre la Entidad.');
            }
            $estado=$rechazados->getIdEstado()->getId();
            if($estado==3)
            {
                $objEstado = $em->getRepository('MinsalsifdaBundle:CatalogoDetalle')->find(1);   
                if (!$objEstado) {
                    throw $this->createNotFoundException('No encontre el Estado.');
                }
                
                $rechazados->setIdEstado($objEstado);
                $em->merge($rechazados);
                $em->flush();                    
                return new Response('1');  
            }     
            //else 
           //  {
             //   $res=$estado;
//                return $this->render('MinsalsifdaBundle:SifdaSolicitudServicio:rechazarSolicitudes.html.twig' , array('entity' =>$entity,'val'=>$res));
//                return new Response('0');
             //} 
//                throw $this->createNotFoundException('No pude rechazar la solicitud.');
        }    
            
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
