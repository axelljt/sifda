<?php
namespace Minsal\sifdaBundle\Repository;
use Doctrine\ORM\EntityRepository;


class SifdaSolicitudServicioRepository extends EntityRepository
{
   /*Repositorio que consulta las solicitudes por rango de fechas*/
   public function FechaSolicitud($fechaInicio, $fechaFin)
    {        
       $dql = "SELECT s FROM MinsalsifdaBundle:SifdaSolicitudServicio s WHERE s.fechaRecepcion BETWEEN '$fechaInicio' AND '$fechaFin' ORDER BY s.fechaRecepcion DESC";	     
       $repositorio = $this->getEntityManager()->createQuery($dql);       
       return $repositorio->getResult();	
    }
    
    
    /*Repositorio que consulta las solicitudes por rango de fechas*/
   public function FechaSolicitudIngresada($fechaInicio, $fechaFin)
    {        
       $dql = "SELECT s FROM MinsalsifdaBundle:SifdaSolicitudServicio s WHERE s.fechaRecepcion BETWEEN '$fechaInicio' AND '$fechaFin' AND s.idEstado=1 ORDER BY s.fechaRecepcion DESC";	     
       $repositorio = $this->getEntityManager()->createQuery($dql);       
       return $repositorio->getResult();	
    }
    
    /*Repositorio que consulta las solicitudes por rango de fechas*/
   public function FechaSolicitudRechazadas($fechaInicio, $fechaFin)
    {        
       $dql = "SELECT s FROM MinsalsifdaBundle:SifdaSolicitudServicio s WHERE s.fechaRecepcion BETWEEN '$fechaInicio' AND '$fechaFin' AND s.idEstado=3 ORDER BY s.fechaRecepcion DESC";	     
       $repositorio = $this->getEntityManager()->createQuery($dql);       
       return $repositorio->getResult();	
    }
    
    /*Repositorio que consulta las solicitudes por rango de fechas*/
   public function FechaSolicitudAsignadas($fechaInicio, $fechaFin)
    {        
       $dql = "SELECT s FROM MinsalsifdaBundle:SifdaSolicitudServicio s WHERE s.fechaRecepcion BETWEEN '$fechaInicio' AND '$fechaFin' AND s.idEstado=2 ORDER BY s.fechaRecepcion DESC";	     
       $repositorio = $this->getEntityManager()->createQuery($dql);       
       return $repositorio->getResult();	
    }
    
    /* Se obtiene la dependencia a la que se le hace la solicitud de servicio */
    public function ObtenerDependencia($id)
    {
        $dql="SELECT ss, de, d.nombre nombre FROM MinsalsifdaBundle:SifdaSolicitudServicio ss JOIN ss.idDependenciaEstablecimiento de JOIN de.idDependencia d WHERE de.id=$id";
         $repositorio = $this->getEntityManager()->createQuery($dql);       
       return $repositorio->getResult();
       //$repositorio = $this->getEntityManager()->createQuery($dql)->setParameter(':solicitud', $id);
        
        //return $repositorio->getResult();     
    }
    
    //Consulta para obtener el numero de solicitudes Ingresadas
    
    public function ContarSolicitudesIngresadas($estado)
    {
        $dql = "SELECT COUNT(s.idEstado) FROM MinsalsifdaBundle:SifdaSolicitudServicio s WHERE s.idEstado=$estado";
        $repositorio=$this->getEntityManager()->createQuery($dql);
        return $repositorio->getOneOrNullResult();
    }
    
    //Consulta para obtener el numero de solicitudes Ingresadas
    
    public function RechazarSolicitudServicio($id)
    {
        $dql = "UPDATE MinsalsifdaBundle:SifdaSolicitudServicio s SET s.idEstado = 3  WHERE s.idEstado=$id";
        $repositorio=$this->getEntityManager()->createQuery($dql);
        return $repositorio->getOneOrNullResult();
            
    }
    
    
    
}

?>
