<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

Class HomeController extends Controller {
    /**
     * @Route("/hello/{prenom}/age/{age}" , name="hello")
     * @Route("/hello" , name="hello_simple")
     * Montrer la page qui dit bonjour 
     * 
     */

    public function hello($prenom= "anonyms",$age=0)
    {
        return $this->render(
            'hello.html.twig' , 
            [
                'prenom'=>$prenom,
                'age'=>$age,
            ]
        );
    }
    /**
     * @Route("/", name="homepage")
     */
    public function home()
    {
        $prénoms=["Nour"=>25, "Samia"=>49, "Kamel"=>55];
        
        return $this->render(
            "Home.html.twig" ,
            [ 
                'title'=>"je t'aime maman à l'infinie",
                'age'=>31,
                'tableau'=>$prénoms
            ]
        );
    }
} 