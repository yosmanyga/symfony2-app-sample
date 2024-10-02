<?php

namespace Claudia\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tipo_rebajas")
 * @ORM\Entity(repositoryClass="Claudia\AppBundle\Entity\TipoRebajaRepository")
 */
class TipoRebaja
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
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(type="float")
     */
    private $porciento;

    /**
     * @var string
     *
     * @ORM\Column(name="dia_inicial", type="integer")
     */
    private $diaInicial;

    /**
     * @var string
     *
     * @ORM\Column(name="dia_final", type="integer")
     */
    private $diaFinal;

    /**
     * @return string
     */
    function __toString()
    {
        return $this->nombre;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getPorciento()
    {
        return $this->porciento;
    }

    /**
     * @param string $porciento
     */
    public function setPorciento($porciento)
    {
        $this->porciento = $porciento;
    }

    /**
     * @return string
     */
    public function getDiaInicial()
    {
        return $this->diaInicial;
    }

    /**
     * @param string $diaInicial
     */
    public function setDiaInicial($diaInicial)
    {
        $this->diaInicial = $diaInicial;
    }

    /**
     * @return string
     */
    public function getDiaFinal()
    {
        return $this->diaFinal;
    }

    /**
     * @param string $diaFinal
     */
    public function setDiaFinal($diaFinal)
    {
        $this->diaFinal = $diaFinal;
    }
}
