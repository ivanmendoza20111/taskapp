<?php
/**
 * Created by PhpStorm.
 * User: ivanm
 * Date: 6/11/2018
 * Time: 11:20 PM
 */

namespace AppBundle\Controller\Task;

use AppBundle\Entity\Ticket;
use AppBundle\Entity\Usuario;
use AppBundle\Form\TicketType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Service\Helpers;

class TaskController extends Controller
{
    /**
     * @Route("/task", name="lista_task", options={"expose"=true} )
     */
    public function indexTask(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $query=$em->createQuery(
            'SELECT t FROM AppBundle:Ticket t 
             JOIN t.usuarioAsignadoId u
             WHERE t.usuarioId=:usuarioId
             ORDER BY t.fechaCreado DESC'
        )->setParameter('usuarioId',$this->getUser()->getId());

        $task=$query->getResult();

        return $this->render('@App/Task/lista.tareas.html.twig', array(
            'tasks'=>$task
        ));
    }

    /**
     * @Route("/task/nuevo", name="nuevo_task", options={"expose"=true} )
     */
    public function nuevoTask(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $query=$em->createQuery('
            SELECT u FROM AppBundle:Usuario u
            WHERE u.tipoUsuario=:tipoUsuario
            ORDER BY u.id asc
        ')->setParameter('tipoUsuario', 'TECNICO');

        $usuarios=$query->getResult();

        $form=$this->createForm(TicketType::class);

        return $this->render('@App/Task/nuevo.html.twig',array(
            'form'=>$form->createView(),
            'usuarios'=>$usuarios
        ));
    }

    //Restful API
    /**
     * @Route("/rest/task", options={"expose"=true}, name="guardar_task")
     * @Method("POST")
     */
    public function guardarUsuario(Request $request)
    {
        $data = $request->getContent();
        $data = (json_decode($data, true));

        $ticket = new Ticket();

        $ticket->setDescripcion($data['descripcion']);
        $ticket->setEstado('Pendiente');
        $ticket->setFecha(new \DateTime());
        $ticket->setFechaCreado(new \DateTime());

        $usarioId=new Usuario();
        $usuarioAsignadoId=new Usuario();

        /*
        $ticket->setUsuarioId($this->getUser()->getId());
        $ticket->setUsuarioAsignadoId($data['usuario_asignado_id']);
        */

        $em = $this->getDoctrine()->getManager();

        //Buscar Usuarios y Pasarlo al Objeto
        $usarioId=$em->getRepository(Usuario::class)->find($this->getUser()->getId());
        $usuarioAsignadoId=$em->getRepository(Usuario::class)->find($data['usuario_asignado_id']);

        $ticket->setUsuarioId($usarioId);
        $ticket->setUsuarioAsignadoId($usuarioAsignadoId);

        $em->persist($ticket);
        $em->flush();

        $helpers = $this->get(Helpers::class);
        return new JsonResponse($helpers->getJsonArray($ticket));
        //return new JsonResponse(null,400);
    }
}