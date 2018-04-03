<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parametro
 *
 * @ORM\Table(name="parametro")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ParametroRepository")
 */
class Parametro
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
     * @ORM\Column(name="valor_texto", type="string", length=255, nullable=true)
     */
    private $valorTexto;

    /**
     * @var int
     *
     * @ORM\Column(name="valor_integer", type="integer", nullable=true)
     */
    private $valorInteger;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_decimal", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $valorDecimal;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="valor_fecha", type="date", nullable=true)
     */
    private $valorFecha;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;


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
     * @return Parametro
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
     * Set valorTexto
     *
     * @param string $valorTexto
     *
     * @return Parametro
     */
    public function setValorTexto($valorTexto)
    {
        $this->valorTexto = $valorTexto;

        return $this;
    }

    /**
     * Get valorTexto
     *
     * @return string
     */
    public function getValorTexto()
    {
        return $this->valorTexto;
    }

    /**
     * Set valorInteger
     *
     * @param integer $valorInteger
     *
     * @return Parametro
     */
    public function setValorInteger($valorInteger)
    {
        $this->valorInteger = $valorInteger;

        return $this;
    }

    /**
     * Get valorInteger
     *
     * @return int
     */
    public function getValorInteger()
    {
        return $this->valorInteger;
    }

    /**
     * Set valorDecimal
     *
     * @param string $valorDecimal
     *
     * @return Parametro
     */
    public function setValorDecimal($valorDecimal)
    {
        $this->valorDecimal = $valorDecimal;

        return $this;
    }

    /**
     * Get valorDecimal
     *
     * @return string
     */
    public function getValorDecimal()
    {
        return $this->valorDecimal;
    }

    /**
     * Set valorFecha
     *
     * @param \DateTime $valorFecha
     *
     * @return Parametro
     */
    public function setValorFecha($valorFecha)
    {
        $this->valorFecha = $valorFecha;

        return $this;
    }

    /**
     * Get valorFecha
     *
     * @return \DateTime
     */
    public function getValorFecha()
    {
        return $this->valorFecha;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Parametro
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
}

