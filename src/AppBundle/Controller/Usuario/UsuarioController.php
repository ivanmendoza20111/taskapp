<?php
/**
 * Created by PhpStorm.
 * User: ivanm
 * Date: 6/11/2018
 * Time: 6:32 PM
 */

namespace AppBundle\Controller\Usuario;

use AppBundle\Entity\Usuario;
use AppBundle\Service\Helpers;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UsuarioController extends Controller
{
    /**
     * @Route("/usuario", name="lista_usuario")
     */
     public function indexUsuario(Request $request)
     {
         /*
          * Insertar Usuario
         $em = $this->getDoctrine()->getManager();

         $usuario = new Usuario();
         $usuario->setNombre("Hector Ventura");
         $usuario->setUsername("hectorventura@gmail.com");

         $em->persist($usuario);

         $em->flush();
        */
         /*Traer todos los usuarios*/
         $usuarios=$this->getDoctrine()
             ->getRepository(Usuario::class)
             ->findAll();


         return $this->render('@App/Usuario/index.html.twig',
             array(
                 "usuarios" => $usuarios
             ));
     }

    /**
     * @Route("/usuario/lista", name="lista_usuario")
     */
     public function listaUsuarioAction(){
         /*Traer todos los usuarios*/
         $usuarios=$this->getDoctrine()
             ->getRepository(Usuario::class)
             ->findAll();

         return $this->render('@App/Usuario/lista.html.twig',
             [
                 "usuarios" => $usuarios
             ]
         );
     }

    /**
     * @Route("/usuario/{idUsuario}", name="informacion_usuario")
     */
    public function indexUsuarioInfo($idUsuario)
    {
        /*Deben tener el mismo nombre para el get, el parametro y la ruta*/
        /*dump solo se usa en desarrollo*/
        //dump("Estamos viendo el usuario: ".$idUsuario);
        return $this->render('@App/Usuario/index.html.twig', [
            'idUsuario'=>$idUsuario
        ]);

    }

    //Restful API

    /**
    * @Route("/rest/usuario/", name="buscar_usuarios")
    * @Method("GET")
    */
    public function buscarUsuarios(Request $request)
    {
        return null;
    }

    /**
     * @Route("/rest/usuario/{id}", name="buscar_usuario")
     * @Method("GET")
     * @ParamConverter("usuario", class="AppBundle:Usuario")
     * @param Usuario $usuario
     */
    public function buscarUsuario($usuario)
    {
        $helpers = $this->get(Helpers::class);
        return new JsonResponse($helpers->getJsonArray($usuario));
    }

    /**
    * @Route("/rest/usuario", name="guardar_usuario")
    * @Method("POST")
    */
    public function guardarUsuario(Request $request)
    {
        $data=$request->getContent();
        $data=(json_decode($data,true));

        $usuario=new Usuario();
        $usuario->setNombre($data["nombre"]);
        $usuario->setUsername($data["Username"]);

        $em=$this->getDoctrine()->getManager();
        $em->persist($usuario);
        $em->flush();

        /* Tarea convertr esto en servicio */
        $helpers = $this->get(Helpers::class);
        return new JsonResponse($helpers-getJsonArray($usuario));

        // sFormType
        // return null;
        // Investigar jms_serializer
        // Servicios en Symfony
        // Tipos de formulario formTypes
        //
    }

    /**
     * @Route("/rest/usuario/{id}", name="actualizar_usuario")
     * @Method("PUT")
     * @ParamConverter("usuario", class="AppBundle:Usuario")
     * @param Request $request
     * @param Usuario $usuario
     * @return JsonResponse
     */
    public function actualizarUsuario(Request $request,$usuario)
    {
        $data=$request->getContent();
        $data=(json_decode($data,true));

        //$usuario->setNombre($data["nombre"]);
        //$usuario->setUsername($data["username"]);

        $em=$this->getDoctrine()->getManager();
        $em->flush();

        $helpers = $this->get(Helpers::class);
        return new JsonResponse($helpers->getJsonArray($usuario));
    }
}