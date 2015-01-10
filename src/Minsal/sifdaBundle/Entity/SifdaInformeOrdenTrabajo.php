<?php

namespace Minsal\sifdaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SifdaInformeOrdenTrabajo
 *
 * @ORM\Table(name="sifda_informe_orden_trabajo", indexes={@ORM\Index(name="es_generado_fk", columns={"id_orden_trabajo"}), @ORM\Index(name="realiza_fk", columns={"id_dependencia_establecimiento"}), @ORM\Index(name="requiere_fk", columns={"id_subactividad"}), @ORM\Index(name="se_generan_fk", columns={"id_etapa"}), @ORM\Index(name="IDX_24D08FE9890253C7", columns={"id_empleado"})})
 * @ORM\Entity
 */
class SifdaInformeOrdenTrabajo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="sifda_informe_orden_trabajo_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="detalle", type="text", nullable=false)
     */
    private $detalle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_realizacion", type="date", nullable=false)
     */
    private $fechaRealizacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_registro", type="date", nullable=false)
     */
    private $fechaRegistro;

    /**
     * @var boolean
     *
     * @ORM\Column(name="terminado", type="boolean", nullable=false)
     */
    private $terminado;

    /**
     * @var \CtlDependenciaEstablecimiento
     *
     * @ORM\ManyToOne(targetEntity="CtlDependenciaEstablecimiento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_dependencia_establecimiento", referencedColumnName="id")
     * })
     */
    private $idDependenciaEstablecimiento;

    /**
     * @var \CtlEmpleado
     *
     * @ORM\ManyToOne(targetEntity="CtlEmpleado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_empleado", referencedColumnName="id")
     * })
     */
    private $idEmpleado;

    /**
     * @var \SifdaOrdenTrabajo
     *
     * @ORM\ManyToOne(targetEntity="SifdaOrdenTrabajo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_orden_trabajo", referencedColumnName="id")
     * })
     */
    private $idOrdenTrabajo;

    /**
     * @var \SifdaRutaCicloVida
     *
     * @ORM\ManyToOne(targetEntity="SifdaRutaCicloVida")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_etapa", referencedColumnName="id")
     * })
     */
    private $idEtapa;

    /**
     * @var \SidplaSubactividad
     *
     * @ORM\ManyToOne(targetEntity="SidplaSubactividad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_subactividad", referencedColumnName="id")
     * })
     */
    private $idSubactividad;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set detalle
     *
     * @param string $detalle
     * @return SifdaInformeOrdenTrabajo
     */
    public function setDetalle($detalle)
    {
        $this->detalle = $detalle;

        return $this;
    }

    /**
     * Get detalle
     *
     * @return string 
     */
    public function getDetalle()
    {
        return $this->detalle;
    }

    /**
     * Set fechaRealizacion
     *
     * @param \DateTime $fechaRealizacion
     * @return SifdaInformeOrdenTrabajo
     */
    public function setFechaRealizacion($fechaRealizacion)
    {
        $this->fechaRealizacion = $fechaRealizacion;

        return $this;
    }

    /**
     * Get fechaRealizacion
     *
     * @return \DateTime 
     */
    public function getFechaRealizacion()
    {
        return $this->fechaRealizacion;
    }

    /**
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     * @return SifdaInformeOrdenTrabajo
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return \DateTime 
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * Set terminado
     *
     * @param boolean $terminado
     * @return SifdaInformeOrdenTrabajo
     */
    public function setTerminado($terminado)
    {
        $this->terminado = $terminado;

        return $this;
    }

    /**
     * Get terminado
     *
     * @return boolean 
     */
    public function getTerminado()
    {
        return $this->terminado;
    }

    /**
     * Set idDependenciaEstablecimiento
     *
     * @param \Minsal\sifdaBundle\Entity\CtlDependenciaEstablecimiento $idDependenciaEstablecimiento
     * @return SifdaInformeOrdenTrabajo
     */
    public function setIdDependenciaEstablecimiento(\Minsal\sifdaBundle\Entity\CtlDependenciaEstablecimiento $idDependenciaEstablecimiento = null)
    {
        $this->idDependenciaEstablecimiento = $idDependenciaEstablecimiento;

        return $this;
    }

    /**
     * Get idDependenciaEstablecimiento
     *
     * @return \Minsal\sifdaBundle\Entity\CtlDependenciaEstablecimiento 
     */
    public function getIdDependenciaEstablecimiento()
    {
        return $this->idDependenciaEstablecimiento;
    }

    /**
     * Set idEmpleado
     *
     * @param \Minsal\sifdaBundle\Entity\CtlEmpleado $idEmpleado
     * @return SifdaInformeOrdenTrabajo
     */
    public function setIdEmpleado(\Minsal\sifdaBundle\Entity\CtlEmpleado $idEmpleado = null)
    {
        $this->idEmpleado = $idEmpleado;

        return $this;
    }

    /**
     * Get idEmpleado
     *
     * @return \Minsal\sifdaBundle\Entity\CtlEmpleado 
     */
    public function getIdEmpleado()
    {
        return $this->idEmpleado;
    }

    /**
     * Set idOrdenTrabajo
     *
     * @param \Minsal\sifdaBundle\Entity\SifdaOrdenTrabajo $idOrdenTrabajo
     * @return SifdaInformeOrdenTrabajo
     */
    public function setIdOrdenTrabajo(\Minsal\sifdaBundle\Entity\SifdaOrdenTrabajo $idOrdenTrabajo = null)
    {
        $this->idOrdenTrabajo = $idOrdenTrabajo;

        return $this;
    }

    /**
     * Get idOrdenTrabajo
     *
     * @return \Minsal\sifdaBundle\Entity\SifdaOrdenTrabajo 
     */
    public function getIdOrdenTrabajo()
    {
        return $this->idOrdenTrabajo;
    }

    /**
     * Set idEtapa
     *
     * @param \Minsal\sifdaBundle\Entity\SifdaRutaCicloVida $idEtapa
     * @return SifdaInformeOrdenTrabajo
     */
    public function setIdEtapa(\Minsal\sifdaBundle\Entity\SifdaRutaCicloVida $idEtapa = null)
    {
        $this->idEtapa = $idEtapa;

        return $this;
    }

    /**
     * Get idEtapa
     *
     * @return \Minsal\sifdaBundle\Entity\SifdaRutaCicloVida 
     */
    public function getIdEtapa()
    {
        return $this->idEtapa;
    }

    /**
     * Set idSubactividad
     *
     * @param \Minsal\sifdaBundle\Entity\SidplaSubactividad $idSubactividad
     * @return SifdaInformeOrdenTrabajo
     */
    public function setIdSubactividad(\Minsal\sifdaBundle\Entity\SidplaSubactividad $idSubactividad = null)
    {
        $this->idSubactividad = $idSubactividad;

        return $this;
    }

    /**
     * Get idSubactividad
     *
     * @return \Minsal\sifdaBundle\Entity\SidplaSubactividad 
     */
    public function getIdSubactividad()
    {
        return $this->idSubactividad;
    }
    
    /**
     * 
     * @return type 
     */
    public function __toString()
    {
        return $this->id.' - '.$this->idOrdenTrabajo->getDescripcion();
    }
}
