<?php

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Entity\Neumaticos;
use App\Entity\Ubicacion;

class NeumaticosRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Neumaticos::class);
        $this->entityManager = $entityManager;
    }

    public function getAllNeumaticos(): ?array
    {
        $sql = $this->createQueryBuilder('n');
        $sql->select('n.codigo', 'n.ancho', 'n.perfil', 'n.diametro', 'n.carga', 'n.marca', 'n.cVelocidad', 'n.stock', 'n.precio', 'c.id as calidad_id', 't.id as tipo_id')
            ->leftJoin('n.calidad', 'c')
            ->leftJoin('n.tipo', 't');

        return $sql->getQuery()->getResult();
    }

    public function getAllMarcas(): ?array
    {
        $sql = $this->createQueryBuilder('n');
        $sql->select('n.marca')
            ->distinct();

        return $sql->getQuery()->getResult();
    }

    public function getNeuByMarca($marca): ?array
    {
        $sql = $this->createQueryBuilder('n')
            ->select('n.codigo', 'n.ancho', 'n.perfil', 'n.diametro', 'n.carga', 'n.cVelocidad', 'n.stock', 'n.precio', 'c.id as calidad_id', 't.id as tipo_id')
            ->leftJoin('n.calidad', 'c')
            ->leftJoin('n.tipo', 't')
            ->where('n.marca = :marca')
            ->setParameter('marca', $marca);

        return $sql->getQuery()->getResult();
    }

    public function getNeuByParams($ancho, $perfil, $diametro, $tipo, $calidad, $carga = null, $cvelocidad = null): ?array
    {
        $sql = $this->createQueryBuilder('n')
            ->select('n.ancho', 'n.perfil', 'n.diametro', 'n.carga', 'n.cVelocidad', 'n.stock', 'n.precio')
            ->where('n.ancho=:ancho AND n.perfil=:perfil AND n.diametro=:diametro AND n.calidad = :calidad AND n.tipo = :tipo')
            ->setParameters(array(
                'ancho' => $ancho,
                'perfil' => $perfil,
                'diametro' => $diametro,
                'calidad' => $calidad,
                'tipo' => $tipo,
            ));

        return $sql->getQuery()->getResult();
    }

    public function saveNeumaticos($data): void
    {

        $ubicacion = $this->entityManager->getRepository(Ubicacion::class)->find(1);

        $neumatico = new Neumaticos();
        $neumatico->setAncho($data['ancho']);
        $neumatico->setPerfil($data['perfil']);
        $neumatico->setDiametro($data['diametro']);
        $neumatico->setCarga($data['carga']);
        $neumatico->setcVelocidad($data['velocidad']);
        $neumatico->setMarca($data['marca']);
        $neumatico->setStock($data['stock']);
        $neumatico->setPrecio($data['precio']);
        $neumatico->setUbicacion($ubicacion);

        $this->entityManager->persist($neumatico);
        $this->entityManager->flush();
    }
}
