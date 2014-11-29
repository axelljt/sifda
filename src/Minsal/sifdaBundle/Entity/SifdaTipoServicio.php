<?php

namespace Minsal\sifdaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SifdaTipoServicio
 *
 * @ORM\Table(name="sifda_tipo_servicio", indexes={@ORM\Index(name="constituye_fk", columns={"id_actividad"})})
 * @ORM\Entity
 */
class SifdaTipoServicio
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="sifda_tipo_servicio_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=75, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=false)
     */
    private $descripcion;

    /**
     * @var \SidplaActividad
     *
     * @ORM\ManyToOne(targetEntity="SidplaActividad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_actividad", referencedColumnName="id")
     * })
     */
    private $idActividad;



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
     * Set nombre
     *
     * @param string $nombre
     * @return SifdaTipoServicio
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return SifdaTipoServicio
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set idActividad
     *
     * @param \Minsal\sifdaBundle\Entity\SidplaActividad $idActividad
     * @return SifdaTipoServicio
     */
    public function setIdActividad(\Minsal\sifdaBundle\Entity\SidplaActividad $idActividad = null)
    {
        $this->idActividad = $idActividad;

        return $this;
    }

    /**
     * Get idActividad
     *
     * @return \Minsal\sifdaBundle\Entity\SidplaActividad 
     */
    public function getIdActividad()
    {
        return $this->idActividad;
    }
    
    public function __toString() {
        return $this->descripcion;
    }
}
