<?php

namespace Minsal\sifdaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SifdaRutaCicloVida
 *
 * @ORM\Table(name="sifda_ruta_ciclo_vida", indexes={@ORM\Index(name="contiene_fk", columns={"id_ruta"})})
 * @ORM\Entity
 */
class SifdaRutaCicloVida
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="sifda_ruta_ciclo_vida_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=100, nullable=false)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="ref1", type="string", length=20, nullable=false)
     */
    private $ref1;

    /**
     * @var integer
     *
     * @ORM\Column(name="jerarquia", type="integer", nullable=false)
     */
    private $jerarquia;

    /**
     * @var integer
     *
     * @ORM\Column(name="ignorar_sig", type="integer", nullable=false)
     */
    private $ignorarSig;

    /**
     * @var integer
     *
     * @ORM\Column(name="peso", type="integer", nullable=false)
     */
    private $peso;

    /**
     * @var \SifdaRuta
     *
     * @ORM\ManyToOne(targetEntity="SifdaRuta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_ruta", referencedColumnName="id")
     * })
     */
    private $idRuta;



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
     * Set descripcion
     *
     * @param string $descripcion
     * @return SifdaRutaCicloVida
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
     * Set ref1
     *
     * @param string $ref1
     * @return SifdaRutaCicloVida
     */
    public function setRef1($ref1)
    {
        $this->ref1 = $ref1;

        return $this;
    }

    /**
     * Get ref1
     *
     * @return string 
     */
    public function getRef1()
    {
        return $this->ref1;
    }

    /**
     * Set jerarquia
     *
     * @param integer $jerarquia
     * @return SifdaRutaCicloVida
     */
    public function setJerarquia($jerarquia)
    {
        $this->jerarquia = $jerarquia;

        return $this;
    }

    /**
     * Get jerarquia
     *
     * @return integer 
     */
    public function getJerarquia()
    {
        return $this->jerarquia;
    }

    /**
     * Set ignorarSig
     *
     * @param integer $ignorarSig
     * @return SifdaRutaCicloVida
     */
    public function setIgnorarSig($ignorarSig)
    {
        $this->ignorarSig = $ignorarSig;

        return $this;
    }

    /**
     * Get ignorarSig
     *
     * @return integer 
     */
    public function getIgnorarSig()
    {
        return $this->ignorarSig;
    }

    /**
     * Set peso
     *
     * @param integer $peso
     * @return SifdaRutaCicloVida
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;

        return $this;
    }

    /**
     * Get peso
     *
     * @return integer 
     */
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * Set idRuta
     *
     * @param \Minsal\sifdaBundle\Entity\SifdaRuta $idRuta
     * @return SifdaRutaCicloVida
     */
    public function setIdRuta(\Minsal\sifdaBundle\Entity\SifdaRuta $idRuta = null)
    {
        $this->idRuta = $idRuta;

        return $this;
    }

    /**
     * Get idRuta
     *
     * @return \Minsal\sifdaBundle\Entity\SifdaRuta 
     */
    public function getIdRuta()
    {
        return $this->idRuta;
    }
}
