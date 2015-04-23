<?php

namespace Claudia\AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class DistribucionRepository extends EntityRepository
{
    /**
     * @param Lote      $lote
     * @param Unidad    $unidad
     * @param int       $cant
     * @param \DateTime $fechaEntrada
     */
    public function registrarDistribucion(
        Lote $lote,
        Unidad $unidad,
        $cant,
        \DateTime $fechaEntrada
    )
    {
        $distribucion = new Distribucion();
        $distribucion->setLote($lote);
        $distribucion->setUnidad($unidad);
        $distribucion->setCant($cant);
        $distribucion->setFechaEntrada($fechaEntrada);

        $this->_em->persist($distribucion);
        $this->_em->flush($distribucion);
    }

    public function obtenerDisponibilidadParaVender(Producto $producto, Unidad $unidad)
    {
        /** @var Lote[] $lotes */
        $lotes = $this->_em->getRepository('ClaudiaAppBundle:Lote')->findBy(array(
            'producto' => $producto)
        );

        $items = array();
        foreach ($lotes as $lote) {
            $cant = $this->obtenerCantidadDisponible($lote, $unidad);

            if ($cant > 0) {
                $items[] = array(
                    'id' => $lote->getId(),
                    'fecha_vencimiento' => $lote->getFechaVencimiento(),
                    'cant' => $cant
                );
            }
        }

        return $items;
    }

    public function obtenerDisponibilidadParaRebajar(Lote $lote)
    {
        $items = array();

        /** @var Unidad[] $unidades */
        $unidades = $this->_em->getRepository('ClaudiaAppBundle:Unidad')->findAll();

        foreach ($unidades as $unidad) {
            $cant = $this->obtenerCantidadDisponible($lote, $unidad);

            if ($cant > 0) {
                $items[] = array(
                    'unidad' => $unidad,
                    'cant' => $cant
                );
            }
        }

        return $items;
    }

    public function obtenerCantidadDisponible(Lote $lote, Unidad $unidad)
    {
        $distribuciones = $this->_em
            ->createQuery("SELECT SUM(D.cant) FROM ClaudiaAppBundle:Distribucion D WHERE D.lote = :lote AND D.unidad = :unidad")
            ->setParameter('lote', $lote)
            ->setParameter('unidad', $unidad)
            ->getSingleScalarResult();

        $ventas = $this->_em
            ->createQuery("SELECT SUM(V.cant) FROM ClaudiaAppBundle:Venta V WHERE V.lote = :lote AND V.unidad = :unidad")
            ->setParameter('lote', $lote)
            ->setParameter('unidad', $unidad)
            ->getSingleScalarResult();

        return $distribuciones - $ventas;
    }
}
