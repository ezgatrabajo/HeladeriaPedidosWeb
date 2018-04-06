<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pedidodetalle
 *
 * @ORM\Table(name="pedidodetalle")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PedidodetalleRepository")
 */
class Pedidodetalle
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


   

    
}

