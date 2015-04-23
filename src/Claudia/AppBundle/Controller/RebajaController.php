<?php

namespace Claudia\AppBundle\Controller;

use Claudia\AppBundle\Entity\DistribucionRepository;
use Claudia\AppBundle\Entity\SurtidoRepository;
use Claudia\AppBundle\Entity\Unidad;
use Claudia\AppBundle\Entity\RebajaRepository;
use Claudia\AppBundle\Entity\LoteRepository;
use Claudia\AppBundle\Entity\Lote;
use Claudia\AppBundle\Form\Type\RegistrarRebaja1Type;
use Claudia\AppBundle\Form\Type\RegistrarRebaja2Type;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class RebajaController extends Controller
{
    /**
     * @param Request $request
     *
     * @return array
     *
     * @Route("/rebaja/registrar1", name="app_rebaja_registrar1")
     * @Template()
     */
    public function registrar1Action(Request $request)
    {
        $form = $this->createForm(new RegistrarRebaja1Type());

        $form->handleRequest($request);

        if ($request->getMethod() == 'POST') {
            if ($form->isValid()) {
                $data = $form->getData();
                /** @var Lote $lote */
                $lote = $data['lote'];

                return $this->redirectToRoute(
                    'app_rebaja_registrar2', 
                    array(
                        'idLote' => $lote->getId()
                    )
                );
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @param int $idLote
     *
     * @return array
     *
     * @Route("/rebaja/registrar2/{idLote}/", name="app_rebaja_registrar2")
     * @Template()
     */
    public function registrar2Action($idLote)
    {
        /** @var Lote $lote */
        $lote = $this->getDoctrine()->getRepository('ClaudiaAppBundle:Lote')->find($idLote);

        /** @var DistribucionRepository $distribucionRepository */
        $distribucionRepository = $this->getDoctrine()->getRepository('ClaudiaAppBundle:Distribucion');
        $distribucionesParaRebajar = $distribucionRepository->obtenerDisponibilidadParaRebajar($lote);
        
        $form1 = $this->createForm(new RegistrarRebaja1Type(), array('lote' => $lote));
        $form2 = $this->createForm(new RegistrarRebaja2Type());

        return array(
            'distribucionesParaRebajar' => $distribucionesParaRebajar,
            'form1' => $form1->createView(),
            'form2' => $form2->createView()
        );
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     *
     * @Route("/rebaja/registrar3", name="app_rebaja_registrar3")
     * @Template()
     */
    public function registrar3Action(Request $request)
    {
        $form2 = $this->createForm(new RegistrarRebaja2Type());

        $form2->handleRequest($request);

        if ($request->getMethod() == 'POST') {
            $data = $form2->getData();

            /** @var RebajaRepository $rebajaRepository */
            $rebajaRepository = $this->getDoctrine()->getRepository('ClaudiaAppBundle:Rebaja');
            $rebajaRepository->registrarRebaja(
                $data['lote'],
                $data['unidad'],
                $data['fechaSolicitud'],
                $data['fechaAprovacion'],
                $data['observaciones'],
                $data['precioAplicado']
            );

            return $this->redirectToRoute('admin', array('entity' => 'Rebaja', 'action' => 'list'));
        }
    }
}
