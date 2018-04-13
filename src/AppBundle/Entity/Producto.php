<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\DecimalType;

/**
 * Producto
 *
 * @ORM\Table(name="producto")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductoRepository")
 */
class Producto
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
     * @ORM\Column(name="codigoexterno", type="string", length=50, nullable=true)
     */
    private $codigoexterno;
    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    
    
    /**
     * @var 
     *
     * @ORM\Column(name="stock", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $stock;
    

    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="string", length=255, nullable=true)
     */
    private $imagen;
    
    
     /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;
    
   
    
     /**
     * @ORM\ManyToOne(targetEntity="Categoria", inversedBy="productos")
     * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     */
    private $categoria;
    
    
    public function getCategoria()
    {
        return $this->categoria;
    }
    
    
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }
    
    
    
   
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Marca", inversedBy="productos")
     * @ORM\JoinColumn(name="marca_id", referencedColumnName="id")
     */
    private $marca;
    
    
    public function getMarca()
    {
        return $this->marca;
    }
    
    
    public function setMarca($marca)
    {
        $this->marca = $marca;

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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Producto
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
     * Set nombre
     *
     * @param string $codigoexterno
     *
     */
    public function setCodigoexterno($codigoexterno)
    {
        $this->codigoexterno = $codigoexterno;

        return $this;
    }

    /**
     * Get codigoexterno
     *
     */
    public function getCodigoexterno()
    {
        return $this->codigoexterno;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Producto
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
     * Set stock
     *
     * @param string 
     *
     * @return DecimalType
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return DecimalType
     */
    public function getStock()
    {
        return $this->stock;
    }
    
    
    
    
    
    
    

    /**
     * Set imagen
     *
     * @param string $imagen
     *
     * @return Producto
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get imagen
     *
     * @return string
     */
    public function getImagen()
    {
        return $this->imagen;
    }
    public function getTextoCombo(){
         return $this->id . ' '. $this->nombre ;
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
    
}

