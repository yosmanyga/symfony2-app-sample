<?php

namespace Claudia\AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class TipoRebajaRepository extends EntityRepository
{
    public function obtenerTodos()
    {
        return $this->findBy([], ['diaFinal' => 'DESC']);
    }
}
