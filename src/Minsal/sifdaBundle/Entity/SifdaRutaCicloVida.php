<?php

namespace Minsal\sifdaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SifdaRutaCicloVida
 *
 * @ORM\Table(name="sifda_ruta_ciclo_vida", uniqueConstraints={@ORM\UniqueConstraint(name="idx_sifda_ruta_ciclo_vida", columns={"id"})}, indexes={@ORM\Index(name="contiene_fk", columns={"id_ruta"}), @ORM\Index(name="idx_id_ruta_etapa", columns={"id_etapa"})})
 * @ORM\Entity(repositoryClass="Minsal\sifdaBundle\Repository\SifdaRutaCicloVidaRepository")
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
     * @ORM\Column(name="ref1", type="string", length=20, nullable=true)
     */
    private $ref1;

    /**
     * @var integer
     *
     * @ORM\Column(name="jerarquia", type="integer", nullable=false)
     */
    private $jerarquia;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ignorar_sig", type="boolean", nullable=false)
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
     * @var \SifdaRutaCicloVida
     *
     * @ORM\ManyToOne(targetEntity="SifdaRutaCicloVida", inversedBy="subetapas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_etapa", referencedColumnName="id")
     * })
     */
    protected $idEtapa;
    
    /**
     * @ORM\OneToMany(targetEntity="SifdaRutaCicloVida", mappedBy="idEtapa")
     */
    protected $subetapas;

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
     * @param boolean $ignorarSig
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
     * @return boolean 
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

    /**
     * Set idEtapa
     *
     * @param \Minsal\sifdaBundle\Entity\SifdaRutaCicloVida $idEtapa
     * @return SifdaRutaCicloVida
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

        public function __construct()
    {
        $this->subetapas = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
        public function __toString() 
    {
        return $this->descripcion;
    }
}
