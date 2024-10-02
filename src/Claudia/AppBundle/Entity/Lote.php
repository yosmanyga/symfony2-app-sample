<?php

namespace Claudia\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="lotes")
 * @ORM\Entity(repositoryClass="Claudia\AppBundle\Entity\LoteRepository")
 */
class Lote
{
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @ORM\Id
     *
     * @Assert\NotBlank()
     */
    private $id;

    /**
     * @var Producto
     *
     * @ORM\ManyToOne(targetEntity="Producto")
     */
    private $producto;

    /**
     * @var float
     *
     * @ORM\Column(name="costo", type="float")
     *
     * @Assert\NotBlank()
     * @Assert\Expression("value < this.getProducto().getPrecio()", message="El costo debe ser menor que el precio del producto.")
     */
    private $costo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vencimiento", type="date")
     *
     * @Assert\Range(min="today", minMessage="La fecha de vencimiento tiene que ser mayor que la actual.")
     */
    private $fechaVencimiento;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    function __toString()
    {
        return sprintf("%s [%s %s]", $this->id, $this->producto->__toString(), $this->fechaVencimiento->format("d/m/Y"));
    }


    /**
     * @param Producto $producto
     */
    public function setProducto(Producto $producto)
    {
        $this->producto = $producto;
    }

    /**
     * @return Producto
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * @param float $costo
     */
    public function setCosto($costo)
    {
        $this->costo = $costo;
    }

    /**
     * @return float
     */
    public function getCosto()
    {
        return $this->costo;
    }

    /**
     * @param \DateTime $fechaVencimiento
     */
    public function setFechaVencimiento(\DateTime $fechaVencimiento)
    {
        $this->fechaVencimiento = $fechaVencimiento;
    }

    /**
     * @return \DateTime
     */
    public function getFechaVencimiento()
    {
        return $this->fechaVencimiento;
    }
}
