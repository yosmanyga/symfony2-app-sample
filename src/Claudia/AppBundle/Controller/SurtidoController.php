<?php

namespace Claudia\AppBundle\Controller;

use Claudia\AppBundle\Entity\SurtidoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class SurtidoController extends Controller
{
    /**
     * @param Request $request
     *
     * @return array
     *
     * @Route("/surtido/ver-graficos", name="app_surtido_ver_graficos")
     * @Template()
     */
    public function verGraficosAction(Request $request)
    {
        /** @var SurtidoRepository $surtidoRepository */
        $surtidoRepository = $this->getDoctrine()->getRepository('ClaudiaAppBundle:Surtido');
        $cantidadesPorFechaEntrada = $surtidoRepository->obtenerCantidadesPorFechaEntrada();

        $cantidadesPorProducto = $surtidoRepository->obtenerCantidadesPorProducto();

        return array(
            'cantidadesPorFechaEntrada' => $cantidadesPorFechaEntrada,
            'cantidadesPorProducto' => $cantidadesPorProducto
        );
    }
}
