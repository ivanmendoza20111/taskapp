<?php
/**
 * Created by PhpStorm.
 * User: ivanm
 * Date: 6/11/2018
 * Time: 6:32 PM
 */

namespace AppBundle\Controller\Usuario;

use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
}