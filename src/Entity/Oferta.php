<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Oferta
 *
 * @ORM\Table(name="oferta", indexes={@ORM\Index(name="OFERTAS_CLIENTE_CLIENTE", columns={"oferta_cli"})})
 * @ORM\Entity
 */
class Oferta
{
    /**
     * @var int
     *
     * @ORM\Column(name="numero", type="smallint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $numero;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @var int|null
     *
     * @ORM\Column(name="descuento", type="smallint", nullable=true)
     */
    private $descuento;

    /**
     * @var string
     *
     * @ORM\Column(name="precio_unidad", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $precioUnidad;

    /**
     * @var string
     *
     * @ORM\Column(name="precio_parcial", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $precioParcial;

    /**
     * @var string
     *
     * @ORM\Column(name="precio_total", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $precioTotal;

    /**
     * @var int
     *
     * @ORM\Column(name="Confirmado", type="smallint", nullable=false)
     */
    private $confirmado = '0';

    /**
     * @var \Cliente
     *
     * @ORM\ManyToOne(targetEntity="Cliente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="oferta_cli", referencedColumnName="DNI")
     * })
     */
    private $ofertaCli;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Neumaticos", inversedBy="nOferta")
     * @ORM\JoinTable(name="oferta_detalle",
     *   joinColumns={
     *     @ORM\JoinColumn(name="N_oferta", referencedColumnName="numero")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="C_articulo", referencedColumnName="codigo")
     *   }
     * )
     */
    private $cArticulo = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cArticulo = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
