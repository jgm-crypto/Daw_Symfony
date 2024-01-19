<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Neumaticos
 *
 * @ORM\Table(name="neumaticos", indexes={@ORM\Index(name="FK_NEUMATICOS_CALIDAD_CALIDAD", columns={"calidad"}), @ORM\Index(name="FK_NEUMATICOS_TIPO_TIPO", columns={"tipo"}), @ORM\Index(name="FK_NEUMATICOS_UBICACION_UBICACION", columns={"ubicacion"})})
 * @ORM\Entity
 */
class Neumaticos
{
    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=15, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codigo;

    /**
     * @var int
     *
     * @ORM\Column(name="ancho", type="smallint", nullable=false)
     */
    private $ancho;

    /**
     * @var int
     *
     * @ORM\Column(name="perfil", type="integer", nullable=false)
     */
    private $perfil;

    /**
     * @var int
     *
     * @ORM\Column(name="diametro", type="integer", nullable=false)
     */
    private $diametro;

    /**
     * @var int
     *
     * @ORM\Column(name="carga", type="integer", nullable=false)
     */
    private $carga;

    /**
     * @var string
     *
     * @ORM\Column(name="c_velocidad", type="string", length=1, nullable=false, options={"fixed"=true})
     */
    private $cVelocidad;

    /**
     * @var int|null
     *
     * @ORM\Column(name="dot", type="integer", nullable=true, options={"default"="2022"})
     */
    private $dot = 2022;

    /**
     * @var string
     *
     * @ORM\Column(name="marca", type="string", length=15, nullable=false)
     */
    private $marca;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mm", type="decimal", precision=10, scale=2, nullable=true, options={"default"="7.00"})
     */
    private $mm = '7.00';

    /**
     * @var int
     *
     * @ORM\Column(name="stock", type="integer", nullable=true, options={"default"="1"})
     */
    private $stock;

    /**
     * @var string|null
     *
     * @ORM\Column(name="precio", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $precio;

    /**
     * @var \Calidad
     *
     * @ORM\ManyToOne(targetEntity="Calidad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="calidad", referencedColumnName="Id")
     * })
     */
    private $calidad;

    /**
     * @var \Tipo
     *
     * @ORM\ManyToOne(targetEntity="Tipo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo", referencedColumnName="Id")
     * })
     */
    private $tipo;

    /**
     * @var \Ubicacion
     *
     * @ORM\ManyToOne(targetEntity="Ubicacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ubicacion", referencedColumnName="Id")
     * })
     */
    private $ubicacion;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Oferta", mappedBy="cArticulo")
     */
    private $nOferta = array();

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Pedido", mappedBy="cArticulo")
     */
    private $nPedido = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->nOferta = new \Doctrine\Common\Collections\ArrayCollection();
        $this->nPedido = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function setAncho($ancho)
    {
        $this->ancho = $ancho;
    }

    public function setPerfil($perfil)
    {
        $this->perfil = $perfil;
    }

    public function setDiametro($diametro)
    {
        $this->diametro = $diametro;
    }

    public function setCarga($carga)
    {
        $this->carga = $carga;
    }

    public function setcVelocidad($cVelocidad)
    {
        $this->cVelocidad = $cVelocidad;
    }

    public function setMarca($marca)
    {
        $this->marca = $marca;
    }

    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    public function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;
    }
}
