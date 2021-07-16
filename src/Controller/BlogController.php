<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function indexaccueil()
    {
        return new Response('<h1>Page d\'accueil indexaccueil</h1>');
    }




    /**
     * @Route("/titi", name="blog")
     */
    public function indextcbhgh()
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'titiController',
            'nompizza'=>"4 fromage"
		 
        ]);
    }


	/**
     * @Route("/pizza2", name="pizza")
     */
    public function indexpizza()
    {
        return $this->render('indexpizza.html.twig', [
            'controller_name' => 'BlogController',
			'pizza_name'=> 'quatres saisons',
        ]);
    }





	/**
     * @Route("/html", name="html")
     */
    public function index3()
    {
        return new Response('<h1>Page d\'accueil index 3</h1>');
    }

   /**
     * @Route("/twig", name="twig")
     */
    public function indextwig()
    {
        return $this->render('blog/indextwig.html.twig', [
            'controller_name' => 'BlogController',
			'test_name'=> 'essai de twig',
        ]);
    }




 public function index()
    {
        return new Response('<h1>Page d\'accueil</h1>');
    }




     public function add()
    {
    	return new Response('<h1>Ajouter un article</h1>');
    }

    public function show($url)
    {
    	return new Response('<h1>Lire l\'article ' .$url. '</h1>');
    }

    public function edit($id)
    {
    	return new Response('<h1>Modifier l\'article ' .$id. '</h1>');
    }

    public function remove($id)
    {
    	return new Response('<h1>Supprimer l\'article ' .$id. '</h1>');
    }
}
