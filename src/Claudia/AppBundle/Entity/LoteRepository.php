<?php

namespace Claudia\AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class LoteRepository extends EntityRepository
{
    /**
     * Devuelve los lotes aplicables a la rebaja dada.
     *
     * @param TipoRebaja $tipoRebaja
     *
     * @return Lote[]
     */
    public function devolverAplicablesARebaja(TipoRebaja $tipoRebaja)
    {
        /** @var Lote[] $lotes */
        $lotes = $this->findAll();

        $lotesAplicablesARebaja = [];
        foreach ($lotes as $lote) {
            // La fecha inicial será la fecha de vencimiento
            // menos cantidad de días inicial
            $fechaInicial = clone $lote->getFechaVencimiento();
            $fechaInicial
                // Restamos la cantidad de días inicial
                ->sub(new \DateInterval(sprintf("P%sD", $tipoRebaja->getDiaInicial())))
                // Restamos 10 días más para el margen de procesamiento
                ->sub(new \DateInterval('P10D'));

            // La fecha final será la fecha de vencimiento
            // menos cantidad de días final
            $fechaFinal = clone $lote->getFechaVencimiento();
            $fechaFinal
                // Restamos la cantidad de días final
                ->sub(new \DateInterval(sprintf("P%sD", $tipoRebaja->getDiaFinal())))
                // Restamos 10 días más para el margen de procesamiento
                ->sub(new \DateInterval('P10D'));

            $fechaActual = new \DateTime();

            // Si la fecha actual está entre la inicial y final entonces el lote
            // es aplicable a la rebaja
            //
            // Línea del tiempo:
            //
            // -----|---------|----------------|------------------------|------>
            //   inicial    actual           final                  vencimiento
            if (
                $fechaInicial < $fechaActual && $fechaActual <= $fechaFinal
            ) {
                $lotesAplicablesARebaja[] = $lote;
            }
        }

        return $lotesAplicablesARebaja;
    }
}
