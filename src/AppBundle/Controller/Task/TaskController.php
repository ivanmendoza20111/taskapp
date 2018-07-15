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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class TaskController extends Controller
{
    /**
     * @Route("/task", name="lista_task", options={"expose"=true} )
     */
    public function indexTask(Request $request)
    {
        $em=$this->getDoctrine()->getManager();

         $task=$this->getDoctrine()->getRepository(Ticket::class)->TicketUsuarios($this->getUser());

        return $this->render('@App/Task/lista.tareas.html.twig', array(
            'tasks'=>$task
        ));
    }

    /**
     * @Route("/task/nuevo", name="nuevo_task", options={"expose"=true} )
     */
    public function nuevoTask(Request $request)
    {

        $usuarios=$this->getDoctrine()->getRepository(Usuario::class)->allUserTecnico();
        $form=$this->createForm(TicketType::class);

        return $this->render('@App/Task/nuevo.html.twig',array(
            'form'=>$form->createView(),
            'usuarios'=>$usuarios
        ));
    }

    /**
     * @Route("/task/ver/{id}", name="ver_task", options={"expose"=true},requirements={"id"="\d+"} )
     * @Method("GET")
     * @param Ticket $ticket
     * @return Response
     */
    public function verTask(Ticket $ticket){
        return $this->render('@App/Task/ver.html.twig',array(
            'ticket'=>$ticket,
            'notas'=>0
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
        $ticket->setFechaCompletado(null);

        $usarioId=new Usuario();
        $usuarioAsignadoId=new Usuario();

        $em = $this->getDoctrine()->getManager();

        //Buscar Usuarios y Pasarlo al Objeto
        $usarioId=$em->getRepository(Usuario::class)->find($this->getUser()->getId());
        $usuarioAsignadoId=$em->getRepository(Usuario::class)->find($data['usuario_asignado_id']);


        $ticket->setUsuario($usarioId);
        $ticket->setUsuarioAsignado($usuarioAsignadoId);

        $em->persist($ticket);
        $em->flush();

        //$helpers = $this->get(Helpers::class);

        //Normalize
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        // Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });

        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);

        $json =  $serializer->serialize($ticket,'json');
        return new JsonResponse($json);
    }
}