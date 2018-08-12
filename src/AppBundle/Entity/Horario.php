<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Horario
 *
 * @ORM\Table(name="horario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HorarioRepository")
 */
class Horario
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
     * @var int
     *
     * @ORM\Column(name="dia", type="integer")
     */
    private $dia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="apertura", type="time")
     */
    private $apertura;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cierre", type="time")
     */
    private $cierre;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=255, nullable=true)
     */
    private $observaciones;


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
     * Set dia
     *
     * @param integer $dia
     *
     * @return Horario
     */
    public function setDia($dia)
    {
        $this->dia = $dia;

        return $this;
    }

    /**
     * Get dia
     *
     * @return int
     */
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * Set apertura
     *
     * @param \DateTime $apertura
     *
     * @return Horario
     */
    public function setApertura($apertura)
    {
        $this->apertura = $apertura;

        return $this;
    }

    /**
     * Get apertura
     *
     * @return \DateTime
     */
    public function getApertura()
    {
        return $this->apertura;
    }

    /**
     * Set cierre
     *
     * @param \DateTime $cierre
     *
     * @return Horario
     */
    public function setCierre($cierre)
    {
        $this->cierre = $cierre;

        return $this;
    }

    /**
     * Get cierre
     *
     * @return \DateTime
     */
    public function getCierre()
    {
        return $this->cierre;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return Horario
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }
}

