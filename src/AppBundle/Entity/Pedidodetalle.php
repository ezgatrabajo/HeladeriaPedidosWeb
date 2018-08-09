<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\IntegerType;
use JsonSerializable;
/**
 * Pedidodetalle
 *
 * @ORM\Table(name="pedidodetalle")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PedidodetalleRepository")
 */
class Pedidodetalle  implements JsonSerializable
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
     * @ORM\Column(name="cantidad", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $cantidad;

    
    /**
     * @var IntegerType
     *
     * @ORM\Column(name="nropote", type="integer",  nullable=true)
     */
    private $nropote;
    
    
    /**
     *
     * @ORM\Column(name="medidapote", type="integer", nullable=true)
     */
    private $medidapote;
    
    
    
    
    
    
    
    
    
    /**
    * @ORM\ManyToOne(targetEntity="Pedido", inversedBy="pedidodetalles")
    * @ORM\JoinColumn(name="pedido_id", referencedColumnName="id")
    */
    private $pedido;
    
    
    public function getPedido()
    {
        return $this->pedido;
    }
    
    
    public function setPedido($pedido)
    {
        $this->pedido = $pedido;

        return $this;
    }
    
    
    /**
    * @ORM\ManyToOne(targetEntity="Producto")
    * @ORM\JoinColumn(name="producto_id", referencedColumnName="id")
    */
    private $producto;
    
    
    public function getProducto()
    {
        return $this->producto;
    }
    
    
    public function setProducto($producto)
    {
        $this->producto = $producto;

        return $this;
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
     * Set cantidad
     *
     * @param string $cantidad
     *
     * @return Pedidodetalle
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return string
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }
    
    
    
    /**
     * Set nropote
     *
     * @param integer $nropote
     *
     * @return Integer
     */
    public function setNropote($nropote)
    {
        $this->nropote = $nropote;
        
        return $this;
    }
    
    /**
     * Get nropote
     *
     * @return integer
     */
    public function getNropote()
    {
        return $this->nropote;
    }
    
    
    
    /**
     * Set medidapote
     *
     * @param integer $medidapote
     *
     * @return Integer
     */
    public function setMedidapote($medidapote)
    {
        $this->medidapote = $medidapote;
        
        return $this;
    }
    
    /**
     * Get medidapote
     *
     * @return integer
     */
    public function getMedidapote()
    {
        return $this->medidapote;
    }
    
    
    
    public function getCantidadString(){
        $texto = "";
        if ($this->cantidad >= GlobalValue::MEDIDA_HELADO_POCO_DESDE && $this->cantidad <=GlobalValue::MEDIDA_HELADO_POCO_HASTA ){
            $texto = "Poco";
        }
        if ($this->cantidad > GlobalValue::MEDIDA_HELADO_EQUILIBRADO_DESDE  && $this->cantidad <=GlobalValue::MEDIDA_HELADO_EQUILIBRADO_HASTA ){
            $texto = "Equilibrado";
        }
        if ($this->cantidad >= GlobalValue::MEDIDA_HELADO_MUCHO_LIMIT_DESDE && $this->cantidad <=GlobalValue::MEDIDA_HELADO_MUCHO_LIMIT_HASTA ){
            $texto = "Mucho";
        }
        return $texto;
    }
    
    public function getMedidaPoteFormat(){
        $_medidapote = "";
        switch ($this->medidapote) {
            case 1000:
                # code...
                $_medidapote = "1 Kg";
                break;
            case 750:
                # code...
                $_medidapote = "3/4 Kg";
                break;
            case 500:
                # code...
                $_medidapote = "1/2 Kg";
                break;
            case 250:
                # code...
                $_medidapote = "1/4 Kg";
                break;
            
            default:
                # code...
                break;
        }
        
        return $_medidapote;
    }
 

    public function jsonSerialize()
    {
        

        return array(
            'pedidodetalle'=>array(
                'id'             => $this->id,
                
                'producto_id'        => $this->getProducto()->getId(),
                'producto_nombre'    => $this->getProducto()->getNombre(),
                'nropote'            => $this->getNropote(),
                'medidapoteformat'   => $this->getMedidaPoteFormat(),
                'cantidad'           => $this->getCantidadString(),
               

                )
        );
    }

    
}

