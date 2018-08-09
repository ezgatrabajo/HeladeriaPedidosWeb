<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Equipo
 *
 * @ORM\Table(name="equipo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EquipoRepository")
 */
class Equipo
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var int
     *
     * @ORM\Column(name="partidosjugados", type="integer")
     */
    private $partidosjugados;

    /**
     * @var int
     *
     * @ORM\Column(name="partidosganados", type="integer")
     */
    private $partidosganados;

    /**
     * @var int
     *
     * @ORM\Column(name="partidosempatados", type="integer")
     */
    private $partidosempatados;

    /**
     * @var int
     *
     * @ORM\Column(name="partidosperdidos", type="integer")
     */
    private $partidosperdidos;

    /**
     * @var int
     *
     * @ORM\Column(name="puntos", type="integer")
     */
    private $puntos;

    /**
     * @var int
     *
     * @ORM\Column(name="golesfavor", type="integer")
     */
    private $golesfavor;

    /**
     * @var int
     *
     * @ORM\Column(name="golesencontra", type="integer")
     */
    private $golesencontra;


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
     * @return Equipo
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
     * Set partidosjugados
     *
     * @param integer $partidosjugados
     *
     * @return Equipo
     */
    public function setPartidosjugados($partidosjugados)
    {
        $this->partidosjugados = $partidosjugados;

        return $this;
    }

    /**
     * Get partidosjugados
     *
     * @return int
     */
    public function getPartidosjugados()
    {
        return $this->partidosjugados;
    }

    /**
     * Set partidosganados
     *
     * @param integer $partidosganados
     *
     * @return Equipo
     */
    public function setPartidosganados($partidosganados)
    {
        $this->partidosganados = $partidosganados;

        return $this;
    }

    /**
     * Get partidosganados
     *
     * @return int
     */
    public function getPartidosganados()
    {
        return $this->partidosganados;
    }

    /**
     * Set partidosempatados
     *
     * @param integer $partidosempatados
     *
     * @return Equipo
     */
    public function setPartidosempatados($partidosempatados)
    {
        $this->partidosempatados = $partidosempatados;

        return $this;
    }

    /**
     * Get partidosempatados
     *
     * @return int
     */
    public function getPartidosempatados()
    {
        return $this->partidosempatados;
    }

    /**
     * Set partidosperdidos
     *
     * @param integer $partidosperdidos
     *
     * @return Equipo
     */
    public function setPartidosperdidos($partidosperdidos)
    {
        $this->partidosperdidos = $partidosperdidos;

        return $this;
    }

    /**
     * Get partidosperdidos
     *
     * @return int
     */
    public function getPartidosperdidos()
    {
        return $this->partidosperdidos;
    }

    /**
     * Set puntos
     *
     * @param integer $puntos
     *
     * @return Equipo
     */
    public function setPuntos($puntos)
    {
        $this->puntos = $puntos;

        return $this;
    }

    /**
     * Get puntos
     *
     * @return int
     */
    public function getPuntos()
    {
        return $this->puntos;
    }

    /**
     * Set golesfavor
     *
     * @param integer $golesfavor
     *
     * @return Equipo
     */
    public function setGolesfavor($golesfavor)
    {
        $this->golesfavor = $golesfavor;

        return $this;
    }

    /**
     * Get golesfavor
     *
     * @return int
     */
    public function getGolesfavor()
    {
        return $this->golesfavor;
    }

    /**
     * Set golesencontra
     *
     * @param integer $golesencontra
     *
     * @return Equipo
     */
    public function setGolesencontra($golesencontra)
    {
        $this->golesencontra = $golesencontra;

        return $this;
    }

    /**
     * Get golesencontra
     *
     * @return int
     */
    public function getGolesencontra()
    {
        return $this->golesencontra;
    }
}

