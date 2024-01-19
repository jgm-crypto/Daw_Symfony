<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pedido
 *
 * @ORM\Table(name="pedido")
 * @ORM\Entity
 */
class Pedido
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
     * @ORM\Column(name="unidades", type="smallint", nullable=true)
     */
    private $unidades;

    /**
     * @var int|null
     *
     * @ORM\Column(name="servido", type="smallint", nullable=true)
     */
    private $servido = '0';

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Neumaticos", inversedBy="nPedido")
     * @ORM\JoinTable(name="pedido_detalle",
     *   joinColumns={
     *     @ORM\JoinColumn(name="N_pedido", referencedColumnName="numero")
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
