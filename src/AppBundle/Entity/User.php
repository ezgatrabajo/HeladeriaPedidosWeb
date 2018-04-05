<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
    
    
    
    
    /**
      * @ORM\Column(name="localidad", type="string", length=50, nullable=true)
     */
    private $localidad;
    
    public function getLocalidad()
    {
        return $this->localidad;
    }
    
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;
        return $this;
    }
    
    
    /**
      * @ORM\Column(name="calle", type="string", length=50, nullable=true)
     */
    private $calle;
    
    public function getCalle()
    {
        return $this->calle;
    }
    
    public function setCalle($calle)
    {
        $this->calle = $calle;
        return $this;
    }
    
    
    /**
      * @ORM\Column(name="nro", type="integer", length=2, nullable=true)
     */
    private $nro;
    
    public function getNro()
    {
        return $this->nro;
    }
    
    public function setNro($nro)
    {
        $this->nro = $nro;
        return $this;
    }
    
    
    /**
      * @ORM\Column(name="piso", type="string", length=10, nullable=true)
     */
    private $piso;
    
    public function getPiso()
    {
        return $this->piso;
    }
    
    public function setPiso($piso)
    {
        $this->piso = $piso;
        return $this;
    }
    
    
    /**
      * @ORM\Column(name="contacto", type="string", length=50, nullable=true)
     */
    private $contacto;
    
    public function getContacto()
    {
        return $this->contacto;
    }
    
    public function setContacto($contacto)
    {
        $this->contacto = $contacto;
        return $this;
    }
    
    
    
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="users" )
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
        return $this;
    }
    
    
     /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Group")
     * @ORM\JoinTable(name="fos_user_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;
    
    
    protected $roles = array();
    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        // allows for chaining
        return $this;
    }
    
    
    
    
    protected $enabled;
    
    public function getEnabled()
    {
        return $this->enabled;
    }
    
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }
    
    /**
    * Get username
    * @return  
    */
    public function getUsername()
    {
        return $this->username;
    }
    
    /**
    * Set username
    * @return $this
    */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
    * Get email
    * @return  
    */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
    * Set email
    * @return $this
    */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
    * Get emailCanonical
    * @return  
    */
    public function getEmailCanonical()
    {
        return $this->emailCanonical;
    }
    
    /**
    * Set emailCanonical
    * @return $this
    */
    public function setEmailCanonical($emailCanonical)
    {
        $this->emailCanonical = $emailCanonical;
        return $this;
    }
    
     /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50 ,nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=50, nullable=true)
     */
    private $apellido;

    /**
     * @var string
     *
     * @ORM\Column(name="ndoc", type="string", length=20, nullable=true)
     */
    private $ndoc;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=50, nullable=true)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=50, nullable=true)
     */
    private $telefono;

    
    
    
    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return string
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
     * Set apellido
     *
     * @param string $apellido
     *
     * @return string
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set ndoc
     *
     * @param string $ndoc
     *
     * @return string
     */
    public function setNdoc($ndoc)
    {
        $this->ndoc = $ndoc;

        return $this;
    }

    /**
     * Get ndoc
     *
     * @return string
     */
    public function getNdoc()
    {
        return $this->ndoc;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return string
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return string
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    
    
    
   
    
    
    public function getTextoCombo()
    {
        return strval ($this->email );
    }
    
    
    
    
   
    
}