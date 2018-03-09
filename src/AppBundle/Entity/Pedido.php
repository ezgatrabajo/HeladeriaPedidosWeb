<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Pedido
 *
 * @ORM\Table(name="pedido")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PedidoRepository")
 */
class Pedido
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
     * @var \Date
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;
    
   

    /**
     * @var int
     *
     * @ORM\Column(name="estado_id", type="integer")
     */
    private $estadoId;

    /**
     * @var int
     *
     * @ORM\Column(name="android_id", type="integer", nullable=true)
     */
    private $android_id;

    /**
     * @var string
     *
     * @ORM\Column(name="subtotal", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $subtotal;

    

    /**
     * @var string
     *
     * @ORM\Column(name="monto", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $monto;
    
    /**
     * @var string
     *
     * @ORM\Column(name="localidad", type="string", length=50, nullable=true)
     */
    private $localidad;
    
    /**
     * @var string
     *
     * @ORM\Column(name="calle", type="string", length=75, nullable=true)
     */
    private $calle;
    
    /**
     * @var string
     *
     * @ORM\Column(name="piso", type="string", length=15, nullable=true)
     */
    private $piso;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nro", type="string", length=15, nullable=true)
     */
    private $nro;
    
    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=25, nullable=true)
     */
    private $telefono;
    
    /**
     * @var string
     *
     * @ORM\Column(name="contacto", type="string", length=50, nullable=true)
     */
    private $contacto;
    
    /**
     * @var string
     *
     * @ORM\Column(name="cucharitas", type="integer",  nullable=true)
     */
    private $cucharitas;
    
     /**
     * @var string
     *
     * @ORM\Column(name="cucuruchos", type="integer",  nullable=true)
     */
    private $cucuruchos;
    
    
            
    
   
    /**
     * @ORM\ManyToOne(targetEntity="Cliente")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     */
    private $cliente;
    
    
    public function getCliente()
    {
        return $this->cliente;
    }
    
    
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
        return $this;
    }

    
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    
    public function getUser()
    {
        return $this->user;
    }
    
    public function setUser($user)
    {
        $this->user = $user;
    }


     /**
     * @ORM\ManyToOne(targetEntity="Empresa")
     * @ORM\JoinColumn(name="empresa_id", referencedColumnName="id")
     */
    private $empresa;
    
    public function getEmpresa()
    {
        return $this->empresa;
    }
    
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;
        
    }
    
     /**
    * @ORM\OneToMany(targetEntity="Pedidodetalle", mappedBy="pedido",cascade={"all"})
    */
    private $pedidodetalles;

    public function __construct()
    {
        $this->pedidodetalles = new ArrayCollection();
    }
    
    public function getPedidodetalles(){
        return $this->pedidodetalles;
    }
    
    public function addPedidodetalle(Pedidodetalle $pd){
        $this->pedidodetalles->add($pd);
        $pd->setPedido($this);


    }
    
    
    
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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Pedido
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    
    
    
    private $fechadesde;
    public function setFechadesde($fechadesde)
    {
        $this->fechadesde = $fechadesde;

        return $this;
    }

    public function getFechadesde()
    {
        return $this->fechadesde;
    }
    
    private $fechahasta;
    public function setFechahasta($fechahasta)
    {
        $this->fechahasta = $fechahasta;

        return $this;
    }
    public function getFechahasta()
    {
        return $this->fechahasta;
    }
    
    
    
    /**
     * Set estado
     *
     * @param integer $estado
     *
     * @return Pedido
     */
    public function setEstadoId($estadoId)
    {
        $this->estadoId = $estadoId;

        return $this;
    }

    /**
     * Get estado
     *
     * @return int
     */
    public function getEstadoId()
    {
        return $this->estadoId;
    }

    /**
     * Set android_id
     *
     * @param integer $android_id
     *
     * @return Pedido
     */
    public function setAndroid_id($android_id)
    {
        $this->android_id = $android_id;

        return $this;
    }

    /**
     * Get android_id
     *
     * @return int
     */
    public function getAndroid_id()
    {
        return $this->android_id;
    }

    /**
     * Set subtotal
     *
     * @param string $subtotal
     *
     * @return Pedido
     */
    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    /**
     * Get subtotal
     *
     * @return string
     */
    public function getSubtotal()
    {
        return $this->subtotal;
    }

   

    /**
     * Set monto
     *
     * @param string $monto
     *
     * @return Pedido
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return string
     */
    public function getMonto()
    {
        return $this->monto;
    }
    

    
    
    
    //--------------------------------------------------------------------------
    //Campos para Heladerias
    //--------------------------------------------------------------------------
    public function getCucharitas()
    {
        return $this->cucharitas;
    }
    public function getCucuruchos()
    {
        return $this->cucuruchos;
    }
    
    
    
    
    public function getLocalidad()
    {
        return $this->localidad;
    }
    
    public function getCalle()
    {
        return $this->calle;
    }
    
    public function getPiso()
    {
        return $this->piso;
    }
    
    public function getNro()
    {
        return $this->nro;
    }
    
    public function getTelefono()
    {
        return $this->telefono;
    }
    
    public function getContacto()
    {
        return $this->contacto;
    }
    
    
    
    //SETTERS -----------------------------------------------------------------
    public function setLocalidad($localidad)
    {
        $this->localidad= $localidad;
    }
    
    public function setCalle($calle)
    {
        $this->calle=$calle;
    }
    
    public function setPiso($piso)
    {
        $this->piso= $piso;
    }
    
    public function setNro($nro)
    {
        $this->nro=$nro;
    }
    
    public function setTelefono($telefono)
    {
        $this->telefono= $telefono;
    }
    
    public function setContacto($contacto)
    {
        $this->contacto= $contacto;
    }
    
    
    public function setCucharitas($cucharitas)
    {
        $this->cucharitas= $cucharitas;
    }
    public function setCucuruchos($cucuruchos)
    {
        $this->cucuruchos=$cucuruchos;
    }
    
    
    
    

    
    
    
}

