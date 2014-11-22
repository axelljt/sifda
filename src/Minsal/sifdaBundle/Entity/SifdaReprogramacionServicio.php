<?php

namespace Minsal\sifdaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SifdaReprogramacionServicio
 *
 * @ORM\Table(name="sifda_reprogramacion_servicio", indexes={@ORM\Index(name="se_traslada_fk", columns={"id_solicitud_servicio"})})
 * @ORM\Entity
 */
class SifdaReprogramacionServicio
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="sifda_reprogramacion_servicio_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_reprogramacion", type="date", nullable=false)
     */
    private $fechaReprogramacion;

    /**
     * @var string
     *
     * @ORM\Column(name="justificacion", type="text", nullable=false)
     */
    private $justificacion;

    /**
     * @var \SifdaSolicitudServicio
     *
     * @ORM\ManyToOne(targetEntity="SifdaSolicitudServicio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_solicitud_servicio", referencedColumnName="id")
     * })
     */
    private $idSolicitudServicio;



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
     * Set fechaReprogramacion
     *
     * @param \DateTime $fechaReprogramacion
     * @return SifdaReprogramacionServicio
     */
    public function setFechaReprogramacion($fechaReprogramacion)
    {
        $this->fechaReprogramacion = $fechaReprogramacion;

        return $this;
    }

    /**
     * Get fechaReprogramacion
     *
     * @return \DateTime 
     */
    public function getFechaReprogramacion()
    {
        return $this->fechaReprogramacion;
    }

    /**
     * Set justificacion
     *
     * @param string $justificacion
     * @return SifdaReprogramacionServicio
     */
    public function setJustificacion($justificacion)
    {
        $this->justificacion = $justificacion;

        return $this;
    }

    /**
     * Get justificacion
     *
     * @return string 
     */
    public function getJustificacion()
    {
        return $this->justificacion;
    }

    /**
     * Set idSolicitudServicio
     *
     * @param \Minsal\sifdaBundle\Entity\SifdaSolicitudServicio $idSolicitudServicio
     * @return SifdaReprogramacionServicio
     */
    public function setIdSolicitudServicio(\Minsal\sifdaBundle\Entity\SifdaSolicitudServicio $idSolicitudServicio = null)
    {
        $this->idSolicitudServicio = $idSolicitudServicio;

        return $this;
    }

    /**
     * Get idSolicitudServicio
     *
     * @return \Minsal\sifdaBundle\Entity\SifdaSolicitudServicio 
     */
    public function getIdSolicitudServicio()
    {
        return $this->idSolicitudServicio;
    }
}
