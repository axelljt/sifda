<?php
namespace Minsal\sifdaBundle\Repository;
use Doctrine\ORM\EntityRepository;


class SifdaSolicitudServicioRepository extends EntityRepository
{
   /*Repositorio que consulta las solicitudes por rango de fechas*/
   public function FechaSolicitud($fechaInicio, $fechaFin)
    {        
       $dql = "SELECT s FROM MinsalsifdaBundle:SifdaSolicitudServicio s WHERE s.fechaRecepcion BETWEEN '$fechaInicio' AND '$fechaFin'";	     
       $repositorio = $this->getEntityManager()->createQuery($dql);       
       return $repositorio->getResult();	
    }
    
}

?>
