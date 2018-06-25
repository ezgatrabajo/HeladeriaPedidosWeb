<?php

namespace AppBundle\Entity;

use DateTime;
use DateInterval;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\DecimalType;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\BooleanType;
use JsonSerializable;
/**
 * Pedido
 *
 * @ORM\Table(name="pedido")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PedidoRepository")
 */
class Pedido  implements JsonSerializable
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
     * @var \Datetime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
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
     * @var DecimalType
     *
     * @ORM\Column(name="subtotal", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $subtotal;

    

    /**
     * @var DecimalType
     *
     * @ORM\Column(name="monto", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $monto;
    
    
    /**
     * @var DecimalType
     *
     * @ORM\Column(name="montoabona", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $montoabona;
    
    
    
    
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
     * @var DecimalType
     *
     * @ORM\Column(name="precio_kilo", type="decimal",  precision=7, scale=2, nullable=true)
     */
    private $precioxkilo;
    
    
    /**
     * @var DecimalType
     *
     * @ORM\Column(name="monto_descuento", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $montodescuento;
    
    
    /**
     * @var IntegerType
     *
     * @ORM\Column(name="cantidad_descuento", type="integer",  nullable=true)
     */
    private $cantidaddescuento;
    
   
   
    
    /**
     * @var IntegerType
     *
     * @ORM\Column(name="cantidad_kilos", type="integer",  nullable=true)
     */
    private $cantidadkilos;
    
    
    /**
     * @var IntegerType
     *
     * @ORM\Column(name="cucharitas", type="integer",  nullable=true)
     */
    private $cucharitas;
    
    
    /**
     * @var IntegerType
     *
     * @ORM\Column(name="cucuruchos", type="integer",  nullable=true)
     */
    private $cucuruchos;
    
    
    /**
     * @var DecimalType
     *
     * @ORM\Column(name="monto_cucuruchos", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $montocucuruchos;
   
    
    /**
     * @var DecimalType
     *
     * @ORM\Column(name="monto_helados", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $montohelados;
    
    
    
    /**
     * @var IntegerType
     *
     * @ORM\Column(name="cantidad_potes", type="integer",  nullable=true)
     */
    private $cantidadpotes;
   
    
    /**
     * @var BooleanType
     *
     * @ORM\Column(name="envio_domicilio", type="boolean",  nullable=true)
     */
    private $enviodomicilio;
    
    
    /**
     * @var BooleanType
     *
     * @ORM\Column(name="visto", type="boolean",  nullable=true)
     */
    private $visto;
    

     /**
     * @var BooleanType
     *
     * @ORM\Column(name="impreso", type="boolean",  nullable=true)
     */
    private $impreso;
    
    /**
     * @var IntegerType
     *
     * @ORM\Column(name="tiempodemora", type="integer",  nullable=true)
     */
    private $tiempodemora;
    
    
    /**
     * @var \Datetime
     *
     * @ORM\Column(name="hora_recepcion", type="datetime", nullable=true)
     */
    private $horarecepcion;
   
    /**
     * @var \Datetime
     *
     * @ORM\Column(name="hora_entrega", type="datetime", nullable=true)
     */
    private $horaentrega;
    
    
    
    
    
    
    //GETTERS AND SETTERS
    
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

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFechaFormatDMY()
    {

        $fecha = $this->fecha->format('d-m-Y');
        return $fecha;
    }

    
    
    
    
    
    
    
   
    public function setHoraEntrega($horaentrega)
    {
        $this->horaentrega = $horaentrega;
        
    }
    
    public function getHoraEntrega()
    {
        return $this->horaentrega;
    }

    public function getHoraEntregaFormatHMS()
    {
        $horaformat =  $this->horaentrega->format('H:i:s');
        return $horaformat;
    }
    
    
    
    
    public function setHoraRecepcion($horarecepcion)
    {
        $this->horarecepcion = $horarecepcion;
        
    }
    
  
    public function getHoraRecepcion()
    {
        return $this->horarecepcion;
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
     * @return DecimalType
     */
    public function getMonto()
    {
        $ma = 0.00;
        if(empty($this->monto)){
            $this->monto = $ma;
        }
        return $this->monto;
    }
    
    
    /**
     * Get monto
     *
     * @return String
     */
    public function getMontoFormat()
    {
        $ma = 0.00;
        if(empty($this->monto)){
            $this->monto = $ma;
        }
        $ma = "$" . $this->monto;
        return $ma;
    }
    
    
    /**
     * Set montoabona
     *
     * @param DecimalType $montoabona
     *
     * @return Pedido
     */
    public function setMontoabona($montoabona)
    {
        $this->montoabona = $montoabona;
        return $this;
    }
    
    /**
     * Get montoabona
     * @return DecimalType
     */
    public function getMontoabona()
    {
        
        return $this->montoabona;
    }
    
    public function getMontoAbonaFormat(){
        
       
        $ma = "$" . strval($this->montoabona);
        
        return $ma;
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
    //Nuevos
    public function getPreciokilo()
    {
        return $this->precioxkilo;
    }
    
    public function getMontodescuento()
    {
        return $this->montodescuento;
    } 
    
    public function getCantidaddescuento()
    {
        return $this->cantidaddescuento;
    }
    
    public function getTiempodemora()
    {
        return $this->tiempodemora;
    } 
    
    public function getCantidadkilos()
    {
        return $this->cantidadkilos;
    } 
    
    public function getMontocucuruchos()
    {
        return $this->montocucuruchos;
    } 
    
    public function getMontohelados()
    {
        return $this->montohelados;
    } 
    
    public function getCantidadpotes()
    {
        return $this->cantidadpotes;
    } 
    
    public function getEnviodomicilio()
    {
        return $this->enviodomicilio;
    }
    

    public function getVisto()
    {
        return $this->visto;
    }
    
    
    public function getDireccionFormat(){
        $_direccion = "$this->calle  $this->nro $this->piso ($this->localidad)";
        return $_direccion;
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
    
    //Nuevos
    public function setPreciokilo($value)
    {
        $this->precioxkilo=$value;
    }
    
    public function setMontodescuento($value)
    {
        $this->montodescuento=$value;
    }
    
    public function setCantidaddescuento($value)
    {
        $this->cantidaddescuento=$value;
    }
    
    public function setTiempodemora($value)
    {
        $this->tiempodemora=$value;
        //Actualizar el campo hora de entrega
        
       // $this->setHoraEntrega($this->getFecha()->add(new DateInterval('PT' . $value . 'M')));
    }
    
    public function setCantidadkilos($value)
    {
        $this->cantidadkilos=$value;
    }
    
    public function setMontocucuruchos($value)
    {
        $this->montocucuruchos=$value;
    }
    
    public function setMontohelados($value)
    {
        $this->montohelados=$value;
    }
    
    public function setCantidadpotes($value)
    {
        $this->cantidadpotes=$value;
    }
    
    public function setEnviodomicilio($value)
    {
        $this->enviodomicilio=$value;
    }
    
    public function setVisto($value)
    {
        $this->visto=$value;
    }
    
    
    

    public function getImpreso()
    {
        return $this->impreso;
    }

    
    public function setImpreso($impreso)
    {
        $this->impreso=$impreso;
    }
    
    public function jsonSerialize()
    {
        /*
        $detalles = array();
        foreach ($this->getPedidodetalles() as $item){
            $detalles->add

        }
        */

        return array(
            'pedido'=>array(
                'id'             => $this->id,
                'fecha'          => $this->getFechaFormatDMY(),
                'horaentrega'    => $this->getHoraEntregaFormatHMS(),
                'contacto'       => $this->getContacto(),
                'direccion'      => $this->getDireccionFormat(),
                'telefono'       => $this->getTelefono(),
                'pedidodetalles' => $this->pedidodetalles,
                'montoabona'=>$this->getMontoAbonaFormat(),
                'monto'=>$this->getMontoFormat()
                )
        );
    }
    
}

