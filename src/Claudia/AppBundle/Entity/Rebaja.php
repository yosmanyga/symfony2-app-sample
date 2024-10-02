<?php

namespace Claudia\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="rebajas")
 * @ORM\Entity(repositoryClass="Claudia\AppBundle\Entity\RebajaRepository")
 */
class Rebaja
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
     * @ORM\Column(name="fecha_solicitud", type="date")
     */
    private $fechaSolicitud;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_aprobacion", type="date")
     */
    private $fechaAprobacion;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $observaciones;

    /**
     * @var string
     *
     * @ORM\Column(name="precio_aplicado", type="string")
     */
    private $precioAplicado;

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
     * @param \DateTime $fechaSolicitud
     */
    public function setFechaSolicitud(\DateTime $fechaSolicitud)
    {
        $this->fechaSolicitud = $fechaSolicitud;
    }

    /**
     * @return \DateTime
     */
    public function getFechaSolicitud()
    {
        return $this->fechaSolicitud;
    }

    /**
     * @return \DateTime
     */
    public function getFechaAprobacion()
    {
        return $this->fechaAprobacion;
    }

    /**
     * @param \DateTime $fechaAprobacion
     */
    public function setFechaAprobacion($fechaAprobacion)
    {
        $this->fechaAprobacion = $fechaAprobacion;
    }

    /**
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * @param string $observaciones
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    }

    /**
     * @return mixed
     */
    public function getPrecioAplicado()
    {
        return $this->precioAplicado;
    }

    /**
     * @param mixed $precioAplicado
     */
    public function setPrecioAplicado($precioAplicado)
    {
        $this->precioAplicado = $precioAplicado;
    }
}
