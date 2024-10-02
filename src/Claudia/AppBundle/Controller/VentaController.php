<?php

namespace Claudia\AppBundle\Controller;

use Claudia\AppBundle\Entity\DistribucionRepository;
use Claudia\AppBundle\Entity\SurtidoRepository;
use Claudia\AppBundle\Entity\Unidad;
use Claudia\AppBundle\Entity\VentaRepository;
use Claudia\AppBundle\Entity\LoteRepository;
use Claudia\AppBundle\Entity\Producto;
use Claudia\AppBundle\Form\Type\RegistrarVenta1Type;
use Claudia\AppBundle\Form\Type\RegistrarVenta2Type;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class VentaController extends Controller
{
    /**
     * @param Request $request
     *
     * @return array
     *
     * @Route("/venta/registrar1", name="app_venta_registrar1")
     * @Template()
     */
    public function registrar1Action(Request $request)
    {
        $form = $this->createForm(new RegistrarVenta1Type());

        $form->handleRequest($request);

        if ($request->getMethod() == 'POST') {
            if ($form->isValid()) {
                $data = $form->getData();
                /** @var Producto $producto */
                $producto = $data['producto'];
                /** @var Unidad $unidad */
                $unidad = $data['unidad'];

                return $this->redirectToRoute(
                    'app_venta_registrar2', 
                    array(
                        'idProducto' => $producto->getId(), 
                        'idUnidad' => $unidad->getId()
                    )
                );
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @param int $idProducto
     * @param int $idUnidad
     *
     * @return array
     *
     * @Route("/venta/registrar2/{idProducto}/{idUnidad}", name="app_venta_registrar2")
     * @Template()
     */
    public function registrar2Action($idProducto, $idUnidad)
    {
        /** @var Producto $producto */
        $producto = $this->getDoctrine()->getRepository('ClaudiaAppBundle:Producto')->find($idProducto);

        /** @var Unidad $unidad */
        $unidad = $this->getDoctrine()->getRepository('ClaudiaAppBundle:Unidad')->find($idUnidad);
        
        /** @var DistribucionRepository $distribucionRepository */
        $distribucionRepository = $this->getDoctrine()->getRepository('ClaudiaAppBundle:Distribucion');
        $lotesParaVender = $distribucionRepository->obtenerDisponibilidadParaVender($producto, $unidad);
        
        $form1 = $this->createForm(new RegistrarVenta1Type(), array('producto' => $producto, 'unidad' => $unidad));
        $form2 = $this->createForm(new RegistrarVenta2Type());

        return array(
            'lotesParaVender' => $lotesParaVender,
            'form1' => $form1->createView(),
            'form2' => $form2->createView()
        );
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     *
     * @Route("/venta/registrar3", name="app_venta_registrar3")
     * @Template()
     */
    public function registrar3Action(Request $request)
    {
        $form2 = $this->createForm(new RegistrarVenta2Type());

        $form2->handleRequest($request);

        if ($request->getMethod() == 'POST') {
            $data = $form2->getData();

            /** @var VentaRepository $ventaRepository */
            $ventaRepository = $this->getDoctrine()->getRepository('ClaudiaAppBundle:Venta');
            $ventaRepository->registrarVenta(
                $data['lote'],
                $data['unidad'],
                $data['cant'],
                $data['fechaVenta']
            );

            return $this->redirectToRoute('admin', array('entity' => 'Venta', 'action' => 'list'));
        }
    }
}
