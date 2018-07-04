<?php
/**
 * Created by PhpStorm.
 * User: ivanm
 * Date: 6/11/2018
 * Time: 6:32 PM
 */

namespace AppBundle\Controller\Usuario;

use AppBundle\Entity\Usuario;
use AppBundle\Form\UsuarioType;
use AppBundle\Service\Helpers;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UsuarioController extends Controller
{
    /**
     * @Route("/usuario", name="lista_usuario")
     */
     public function indexUsuario(Request $request)
     {
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
     * @Route("/usuario/{id}", name="editar_usuario", requirements={"id"="\d+"})
     * @Method("GET")
     * @param Usuario $usuario
     * @return Response
     */
    public function indexEditUsuario(Usuario $usuario)
    {
        return $this->render('@App/Usuario/editar_usuario.html.twig',
            array(
                "usuario" => $usuario
            ));
    }

    /**
     * @Route("/usuario/eliminar/{id}", name="eliminar_usuario", requirements={"id"="\d+"})
     * @Method("GET")
     * @param Usuario $usuario
     * @return Response
     */
    public function indexEliminarUsuario(Usuario $usuario)
    {
        /* Eliminar */
        $em=$this->getDoctrine()->getManager();
        $em->remove($usuario);
        $em->flush();

        return $this->redirectToRoute('lista_usuario');
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
    * @Route("/rest/usuario/",options={"expose"=true}, name="buscar_usuarios")
    * @Method("GET")
    */
    public function buscarUsuarios(Request $request)
    {
        return null;
    }

    /**
     * @Route("/rest/usuario/{id}",options={"expose"=true}, name="buscar_usuario")
     * @Method("GET")
     * @param Usuario $usuario
     */
    public function buscarUsuario(Usuario $usuario)
    {
        $helpers = $this->get(Helpers::class);
        return new JsonResponse($helpers->getJsonArray($usuario));
    }

    /**
    * @Route("/rest/usuario", options={"expose"=true}, name="guardar_usuario")
    * @Method("POST")
    */
    public function guardarUsuario(Request $request)
    {
        $data = $request->getContent();
        $data = (json_decode($data, true));

        $usuario = new Usuario();

        //Para Insertar por Form
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->submit($data);

        //Para acceder a los valores
        //$usuario->setNombre($data["nombre"]);
        //$usuario->setUsername($data["Username"]);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();
            $helpers = $this->get(Helpers::class);
            return new JsonResponse($helpers->getJsonArray($usuario));
        }

        //$errors=$form->getErrors();

        return new JsonResponse(null,400);
    }

    /**
     * @Route("/rest/usuario/{id}",options={"expose"=true}, name="actualizar_usuario")
     * @Method("PUT")
     * @param Request $request
     * @param Usuario $usuario
     * @return JsonResponse
     */
    public function actualizarUsuario(Request $request,Usuario $usuario)
    {
        $data=$request->getContent();
        $data=(json_decode($data,true));

        //Para Insertar por Form
        $form=$this->createForm(UsuarioType::class, $usuario);
        $form->submit($data);

        //$usuario->setNombre($data["nombre"]);
        //$usuario->setUsername($data["username"]);

        $em=$this->getDoctrine()->getManager();
        $em->flush();

        $jsonContent = $this->get('serializer')->serialize($usuario, 'json');
        $jsonContent = json_decode($jsonContent,true);

        return new JsonResponse($jsonContent);
        /*
        $helpers = $this->get(Helpers::class);
        return new JsonResponse($helpers->getJsonArray($usuario));
        */
    }

    /**
     * @Route("/rest/usuario/{id}",options={"expose"=true}, name="eliminar_usuario2")
     * @Method("DELETE")
     * @param Usuario $usuario
     * @return Response
     */
    public function eliminarUsuario(Usuario $usuario)
    {
        /* Eliminar */
        $em=$this->getDoctrine()->getManager();
        $em->remove($usuario);
        $em->flush();
        return new Response("1");
    }

}