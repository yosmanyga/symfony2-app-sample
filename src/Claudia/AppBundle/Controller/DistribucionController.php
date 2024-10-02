<?php

namespace Claudia\AppBundle\Controller;

use Claudia\AppBundle\Entity\DistribucionRepository;
use Claudia\AppBundle\Entity\LoteRepository;
use Claudia\AppBundle\Entity\Producto;
use Claudia\AppBundle\Entity\SurtidoRepository;
use Claudia\AppBundle\Form\Type\RegistrarDistribucion1Type;
use Claudia\AppBundle\Form\Type\RegistrarDistribucion2Type;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class DistribucionController extends Controller
{
    /**
     * @param Request $request
     * @return array
     *
     * @Route("/distribucion/registrar1", name="app_distribucion_registrar1")
     * @Template()
     */
    public function registrar1Action(Request $request)
    {
        $form = $this->createForm(new RegistrarDistribucion1Type());

        $form->handleRequest($request);

        if ($request->getMethod() == 'POST') {
            if ($form->isValid()) {
                $data = $form->getData();
                /** @var Producto $producto */
                $producto = $data['producto'];

                return $this->redirectToRoute('app_distribucion_registrar2', array('idProducto' => $producto->getId()));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @param int $idProducto
     * @return array
     *
     * @Route("/distribucion/registrar2/{idProducto}", name="app_distribucion_registrar2")
     * @Template()
     */
    public function registrar2Action($idProducto)
    {
        /** @var Producto $producto */
        $producto = $this->getDoctrine()->getRepository('ClaudiaAppBundle:Producto')->find($idProducto);

        /** @var SurtidoRepository $surtidoRepository */
        $surtidoRepository = $this->getDoctrine()->getRepository('ClaudiaAppBundle:Surtido');
        $lotesParaDistribuir = $surtidoRepository->obtenerDisponibilidadParaDistribuir($producto);

        $form1 = $this->createForm(new RegistrarDistribucion1Type(), array('producto' => $producto));
        $form2 = $this->createForm(new RegistrarDistribucion2Type());

        return array(
            'lotesParaDistribuir' => $lotesParaDistribuir,
            'form1' => $form1->createView(),
            'form2' => $form2->createView()
        );
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     *
     * @Route("/distribucion/registrar3", name="app_distribucion_registrar3")
     * @Template()
     */
    public function registrar3Action(Request $request)
    {
        $form2 = $this->createForm(new RegistrarDistribucion2Type());

        $form2->handleRequest($request);

        if ($request->getMethod() == 'POST') {
            $data = $form2->getData();

            /** @var DistribucionRepository $distribucionRepository */
            $distribucionRepository = $this->getDoctrine()->getRepository('ClaudiaAppBundle:Distribucion');
            $distribucionRepository->registrarDistribucion(
                $data['lote'],
                $data['unidad'],
                $data['cant'],
                $data['fechaEntrada']
            );

            return $this->redirectToRoute('admin', array('entity' => 'Distribucion', 'action' => 'list'));
        }
    }
}
