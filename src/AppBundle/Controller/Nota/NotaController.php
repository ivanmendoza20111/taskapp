<?php
/**
 * Created by PhpStorm.
 * User: ivanm
 * Date: 7/15/2018
 * Time: 11:58 AM
 */

namespace AppBundle\Controller\Nota;

use AppBundle\Entity\Nota;
use AppBundle\Entity\Ticket;
use AppBundle\Form\NotaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class NotaController extends Controller
{
    //Restful
    /**
     * @Route("/rest/notas/guardar/{id}",options={"expose"=true}, name="guardar_noras")
     * @Method("POST")
     * @param Request $request
     * @param Ticket $ticket
     * @return Response
     */
    public function guardarNotas(Request $request,Ticket $ticket)
    {
        $data = $request->getContent();
        $data = (json_decode($data, true));

        $nota=new Nota();

        if($data['comentario']!='') {
            $nota->setUsuario($this->getUser());
            $nota->setComentario($data['comentario']);
            $nota->setTicket($ticket);
            $nota->setFecha(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($nota);
            $em->flush();
            return new Response("1");
        }

        return new Response("0");

    }
}