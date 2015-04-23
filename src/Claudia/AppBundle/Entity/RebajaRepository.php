<?php

namespace Claudia\AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class RebajaRepository extends EntityRepository
{
    /**
     * @param Lote      $lote
     * @param Unidad    $unidad
     * @param \DateTime $fechaSolicitud
     * @param \DateTime $fechaAprobacion
     * @param string    $observaciones
     * @param string    $precioAplicado
     */
    public function registrarRebaja(
        Lote $lote,
        Unidad $unidad,
        \DateTime $fechaSolicitud,
        \DateTime $fechaAprobacion,
        $observaciones,
        $precioAplicado
    )
    {
        /** @var DistribucionRepository $distribucionRepository */
        $distribucionRepository = $this->_em->getRepository('ClaudiaAppBundle:Distribucion');

        $rebaja = new Rebaja();
        $rebaja->setLote($lote);
        $rebaja->setUnidad($unidad);
        $rebaja->setCant($distribucionRepository->obtenerCantidadDisponible($lote, $unidad));
        $rebaja->setFechaSolicitud($fechaSolicitud);
        $rebaja->setFechaAprobacion($fechaAprobacion);
        $rebaja->setObservaciones($observaciones);
        $rebaja->setPrecioAplicado($precioAplicado);

        $this->_em->persist($rebaja);
        $this->_em->flush($rebaja);
    }
}
