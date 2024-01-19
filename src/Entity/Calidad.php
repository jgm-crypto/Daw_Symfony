<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Calidad
 *
 * @ORM\Table(name="calidad")
 * @ORM\Entity
 */
class Calidad
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="calidad", type="string", length=10, nullable=false)
     */
    private $calidad;


}
