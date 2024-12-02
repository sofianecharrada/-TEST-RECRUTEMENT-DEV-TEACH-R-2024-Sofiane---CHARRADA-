<?php

namespace App\Controller;

use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitsController extends AbstractController
{

    /**
     * This function display all products
     *
     * @param ProduitsRepository $repository
     * @return Response
     */
    #[Route('/produits', name: 'produits', methods: ['GET'])]
    public function index(ProduitsRepository $repository): Response
    {
        return $this->render('pages/produits/index.html.twig', [
            'produits' => $repository->findAll()
        ]);
    }

    #[Route('/produits/nouveau', 'produits.new', methods: ['GET', 'POST'])]
    public function new(): Response
    {
        return $this->render('pages/produits/new.html.twig');
    }
}
