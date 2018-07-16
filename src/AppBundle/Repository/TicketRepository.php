<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Usuario;

/**
 * TicketRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TicketRepository extends \Doctrine\ORM\EntityRepository
{
    public function TicketUsuarios(Usuario $user, $estado=''){
        return $this->getEntityManager()->createQuery("
                SELECT t FROM AppBundle:Ticket t
                WHERE (t.usuario=:usuario_id or t.usuarioAsignado=:usuario_id) and (t.estado=:estado or :estado='')
                ORDER BY t.fecha DESC
        ")->setParameter('usuario_id',$user)->setParameter('estado',$estado)-> getResult();
    }
}
