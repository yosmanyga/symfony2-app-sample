<?php

namespace Claudia\AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class SurtidoRepository extends EntityRepository
{
    public function obtenerDisponibilidadParaDistribuir(Producto $producto)
    {
        /** @var Lote[] $lotes */
        $lotes = $this->_em->getRepository('ClaudiaAppBundle:Lote')->findBy(array(
            'producto' => $producto)
        );

        $items = array();
        foreach ($lotes as $lote) {
            $surtidos = $this->_em
                ->createQuery("SELECT SUM(S.cant) FROM ClaudiaAppBundle:Surtido S WHERE S.lote = :lote")
                ->setParameter('lote', $lote)
                ->getSingleScalarResult();

            $distribuciones = $this->_em
                ->createQuery("SELECT SUM(D.cant) FROM ClaudiaAppBundle:Distribucion D WHERE D.lote = :lote")
                ->setParameter('lote', $lote)
                ->getSingleScalarResult();

            if ($surtidos - $distribuciones > 0) {
                $items[] = array(
                    'id' => $lote->getId(),
                    'fecha_vencimiento' => $lote->getFechaVencimiento(),
                    'cant' => $surtidos - $distribuciones
                );
            }
        }

        return $items;
    }

    public function obtenerCantidadesPorFechaEntrada()
    {
        $items = $this->_em
            ->createQuery("
                SELECT MONTH(S.fechaEntrada) as mes
                FROM ClaudiaAppBundle:Surtido S
            ")
            ->getResult();

        $cantidades = [
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
            '6' => 0,
            '7' => 0,
            '8' => 0,
            '9' => 0,
            '10' => 0,
            '11' => 0,
            '12' => 0,
        ];
        foreach ($items as $item) {
            $cantidades[$item['mes']]++;
        }

        return $cantidades;
    }

    public function obtenerCantidadesPorProducto()
    {
        $cantidades = $this->_em
            ->createQuery("
                SELECT COUNT(S.lote) as cantidad, P.nombre
                FROM ClaudiaAppBundle:Surtido S
                JOIN S.lote L
                JOIN L.producto P
                GROUP BY S.lote
            ")
            ->getResult();

        return $cantidades;
    }
}
