<?php

namespace Claudia\AppBundle\Command;

use Claudia\AppBundle\Entity\LoteRepository;
use Claudia\AppBundle\Entity\TipoRebaja;
use Claudia\AppBundle\Entity\TipoRebajaRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;

class AppLotesRebajaCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:lotes:rebaja')
            ->setDescription('Notifica los lotes aplicables a rebaja.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var \Doctrine\Bundle\DoctrineBundle\Registry $doctrine */
        $doctrine = $this->getContainer()->get('doctrine');
        /** @var LoteRepository $loteRepository */
        $loteRepository = $doctrine->getRepository('ClaudiaAppBundle:Lote');
        /** @var TipoRebajaRepository $tipoRebajaRepository */
        $tipoRebajaRepository = $doctrine->getRepository('ClaudiaAppBundle:TipoRebaja');
        
        /** @var TipoRebaja[] $tiposRebaja */
        $tiposRebaja = $tipoRebajaRepository->obtenerTodos();

        $correoOutput = new BufferedOutput();

        $line = "Lotes aplicables a rebaja:";
        $output->writeln(sprintf("<info>%s</info>", $line));
        $output->writeln("");
        $correoOutput->writeln($line);
        $correoOutput->writeln("");

        foreach ($tiposRebaja as $tipoRebaja) {
            $lotes = $loteRepository->devolverAplicablesARebaja($tipoRebaja);

            if (count($lotes) > 0) {
                $line = sprintf(
                    "Tipo de rebaja: %s %s%% (entre %s y %s días):",
                    $tipoRebaja->getNombre(),
                    $tipoRebaja->getPorciento(),
                    $tipoRebaja->getDiaInicial(),
                    $tipoRebaja->getDiaFinal()
                );
                $output->writeln(sprintf("<info>%s</info>", $line));
                $correoOutput->writeln($line);

                /** @var Table $table */
                $table = $this->getHelperSet()->get('table');
                $table->setHeaders(array('Lote', 'Producto', 'Fecha de vencimiento'));
                foreach ($lotes as $i => $lote) {
                    $table->setRow($i, [
                        $lote->getId(),
                        $lote->getProducto()->getNombre(),
                        $lote->getFechaVencimiento()->format('j/n/Y')
                    ]);
                }

                $table->render($output);
                $table->render($correoOutput);
                $output->writeln("");
                $correoOutput->writeln("");
            }
        }

        $message = \Swift_Message::newInstance()
            ->setSubject('Lotes aplicables a rebaja')
            ->setFrom($this->getContainer()->getParameter('system_email'))
            ->setTo($this->getContainer()->getParameter('admin_email'))
            ->setBody($correoOutput->fetch());

        /** @var \Swift_Mailer $mailer */
        $mailer = $this->getContainer()->get('mailer');
        $mailer->send($message);
    }
}
