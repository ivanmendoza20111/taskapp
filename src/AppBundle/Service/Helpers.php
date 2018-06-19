<?php
/**
 * Created by PhpStorm.
 * User: ivanm
 * Date: 6/18/2018
 * Time: 10:45 PM
 */

namespace AppBundle\Service;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;


class Helpers
{

    public  function getJsonArray($data){
        $encoders=array(new JsonEncoder());
        $normalizers=array(new ObjectNormalizer());
        $serializer=new Serializer($normalizers,$encoders);

        $jsonContent=json_decode($serializer->serialize($data,'json'),true);

        return $jsonContent;
    }
}