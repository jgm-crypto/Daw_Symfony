<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Citas
 *
 * @ORM\Table(name="citas", indexes={@ORM\Index(name="CITA_OFERTA_COD_OFERTA", columns={"oferta_cod"})})
 * @ORM\Entity
 */
class Citas
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id", type="smallint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Dia", type="date", nullable=false)
     */
    private $dia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Hora", type="time", nullable=false)
     */
    private $hora;

    /**
     * @var \Oferta
     *
     * @ORM\ManyToOne(targetEntity="Oferta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="oferta_cod", referencedColumnName="numero")
     * })
     */
    private $ofertaCod;


}
