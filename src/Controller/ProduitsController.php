<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Form\ProduitType;
use App\Repository\ProduitsRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProduitsController extends AbstractController
{

    /**
     * This controller display all products
     *
     * @param ProduitsRepository $repository
     * @return Response
     */
    #[Route('/produits', name: 'produits.index', methods: ['GET'])]
    public function index(ProduitsRepository $repository): Response
    {
        return $this->render('pages/produits/index.html.twig', [
            'produits' => $repository->findAll()
        ]);
    }


    /**
     * This controller show a form which create a product
     *
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    #[Route('/produits/nouveau', 'produits.new', methods: ['GET', 'POST'])]
    public function new(
        EntityManagerInterface $manager,
        Request $request
    ): Response {
        $produits = new Produits();
        $form = $this->createForm(ProduitType::class, $produits);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $produits = $form->getData();

            $manager->persist($produits);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre produit a été créer avec succés !'
            );

            return $this->redirectToRoute('produits.index');
        }


        return $this->render('pages/produits/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/produits/edition/{id}', 'produits.edit', methods: ['GET', 'POST'])]
    public function edit(
        ProduitsRepository $repository,
        int $id,
        Request $request,
        EntityManagerInterface $manager
        ): Response
    {
        $produits = $repository->findOneBy(["id" => $id]);
        $form = $this->createForm(ProduitType::class, $produits);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $produits = $form->getData();

            $manager->persist($produits);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre produit a été modifié avec succés !'
            );

            return $this->redirectToRoute('produits.index');
        }

        return $this->render('pages/produits/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/produits/suppression/{id}', name: 'produits.delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, Produits $produits) : Response
    {   

        if(!$produits){

            $this->addFlash(
                'success',
                'Votre produit n\'a pas été trouvé'
            );
    
            return $this->redirectToRoute('produits.index');
        }
        $manager->remove($produits);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre produit à été supprimé avec succés'
        );

        return $this->redirectToRoute('produits.index');
    }
}
