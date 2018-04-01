<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Promo
 *
 * @ORM\Table(name="promo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PromoRepository")
 */
class Promo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechadesde", type="date", nullable=true)
     */
    private $fechadesde;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechahasta", type="date", nullable=true)
     */
    private $fechahasta;

    /**
     * @var int
     *
     * @ORM\Column(name="cantidadkilos", type="integer", nullable=true)
     */
    private $cantidadkilos;

    /**
     * @var string
     *
     * @ORM\Column(name="importedescuento", type="decimal", precision=7, scale=2)
     */
    private $importedescuento;

    /**
     * @var string
     *
     * @ORM\Column(name="preciopromo", type="decimal", precision=7, scale=2)
     */
    private $preciopromo;

    /**
     * @var string
     *
     * @ORM\Column(name="precioanterior", type="decimal", precision=7, scale=2)
     */
    private $precioanterior;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Promo
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
     *
     * @return Promo
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
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Promo
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set fechadesde
     *
     * @param \DateTime $fechadesde
     *
     * @return Promo
     */
    public function setFechadesde($fechadesde)
    {
        $this->fechadesde = $fechadesde;

        return $this;
    }

    /**
     * Get fechadesde
     *
     * @return \DateTime
     */
    public function getFechadesde()
    {
        return $this->fechadesde;
    }

    /**
     * Set fechahasta
     *
     * @param \DateTime $fechahasta
     *
     * @return Promo
     */
    public function setFechahasta($fechahasta)
    {
        $this->fechahasta = $fechahasta;

        return $this;
    }

    /**
     * Get fechahasta
     *
     * @return \DateTime
     */
    public function getFechahasta()
    {
        return $this->fechahasta;
    }

    /**
     * Set cantidadkilos
     *
     * @param integer $cantidadkilos
     *
     * @return Promo
     */
    public function setCantidadkilos($cantidadkilos)
    {
        $this->cantidadkilos = $cantidadkilos;

        return $this;
    }

    /**
     * Get cantidadkilos
     *
     * @return int
     */
    public function getCantidadkilos()
    {
        return $this->cantidadkilos;
    }

    /**
     * Set importedescuento
     *
     * @param string $importedescuento
     *
     * @return Promo
     */
    public function setImportedescuento($importedescuento)
    {
        $this->importedescuento = $importedescuento;

        return $this;
    }

    /**
     * Get importedescuento
     *
     * @return string
     */
    public function getImportedescuento()
    {
        return $this->importedescuento;
    }

    /**
     * Set preciopromo
     *
     * @param string $preciopromo
     *
     * @return Promo
     */
    public function setPreciopromo($preciopromo)
    {
        $this->preciopromo = $preciopromo;

        return $this;
    }

    /**
     * Get preciopromo
     *
     * @return string
     */
    public function getPreciopromo()
    {
        return $this->preciopromo;
    }

    /**
     * Set precioanterior
     *
     * @param string $precioanterior
     *
     * @return Promo
     */
    public function setPrecioanterior($precioanterior)
    {
        $this->precioanterior = $precioanterior;

        return $this;
    }

    /**
     * Get precioanterior
     *
     * @return string
     */
    public function getPrecioanterior()
    {
        return $this->precioanterior;
    }
}

