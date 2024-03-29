<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        return $this->render('home/articles.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
