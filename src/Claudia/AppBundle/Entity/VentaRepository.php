<?php

namespace Claudia\AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class VentaRepository extends EntityRepository
{
    /**
     * @param Lote      $lote
     * @param Unidad    $unidad
     * @param int       $cant
     * @param \DateTime $fechaVenta
     */
    public function registrarVenta(
        Lote $lote,
        Unidad $unidad,
        $cant,
        \DateTime $fechaVenta
    )
    {
        $venta = new Venta();
        $venta->setLote($lote);
        $venta->setUnidad($unidad);
        $venta->setCant($cant);
        $venta->setFechaVenta($fechaVenta);

        $this->_em->persist($venta);
        $this->_em->flush($venta);
    }
}
