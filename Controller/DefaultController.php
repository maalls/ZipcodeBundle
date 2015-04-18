<?php

namespace Maalls\ZipcodeBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Maalls\Zipcode\Zipcode;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function zipcodeAction($country, $zipcode)
    {
        
        $zipcoder = $this->get("maalls.zipcode");    
        try {    
        
            $address = $zipcoder->zipcode($zipcode, $country);
            $rsp = array("status" => "ok", "data" => $address);

        }
        catch(\Exception $e) {

            $rsp = array("status" => "error", "message" => $e->getMessage());

        }

        $response = new Response();
        $response->setContent(json_encode($rsp));
        $response->headers->set('Content-Type', 'application/json');
        return $response;

        //return $this->render('MaallsZipcodeBundle:Default:index.html.twig', array('name' => $name));
    }
}
