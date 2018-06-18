<?php
/**
 * Created by PhpStorm.
 * User: ivanm
 * Date: 6/11/2018
 * Time: 11:20 PM
 */

namespace AppBundle\Controller\Task;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends Controller
{
    /**
     * @Route("/task", name="lista_task")
     */
    public function indexTask(Request $request)
    {
        return $this->render('@App/Task/lista.tareas.html.twig');
    }
}