<?php

namespace Claudia\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="distribuciones")
 * @ORM\Entity(repositoryClass="Claudia\AppBundle\Entity\DistribucionRepository")
 */
class Distribucion
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Lote
     *
     * @ORM\ManyToOne(targetEntity="Lote")
     */
    private $lote;

    /**
     * @var Unidad
     *
     * @ORM\ManyToOne(targetEntity="Unidad")
     */
    private $unidad;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $cant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_entrada", type="date")
     */
    private $fechaEntrada;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Lote $lote
     */
    public function setLote(Lote $lote)
    {
        $this->lote = $lote;
    }

    /**
     * @return Lote
     */
    public function getLote()
    {
        return $this->lote;
    }

    /**
     * @return Unidad
     */
    public function getUnidad()
    {
        return $this->unidad;
    }

    /**
     * @param Unidad $unidad
     */
    public function setUnidad(Unidad $unidad)
    {
        $this->unidad = $unidad;
    }

    /**
     * @return int
     */
    public function getCant()
    {
        return $this->cant;
    }

    /**
     * @param int $cant
     */
    public function setCant($cant)
    {
        $this->cant = $cant;
    }

    /**
     * @param \DateTime $fechaEntrada
     */
    public function setFechaEntrada(\DateTime $fechaEntrada)
    {
        $this->fechaEntrada = $fechaEntrada;
    }

    /**
     * @return \DateTime
     */
    public function getFechaEntrada()
    {
        return $this->fechaEntrada;
    }
}
