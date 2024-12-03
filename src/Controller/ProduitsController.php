<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Produits;
use App\Form\ProduitType;
use App\Repository\ProduitsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitsController extends AbstractController
{
    /**
     * This controller displays all products
     *
     * @param ProduitsRepository $repository
     * @return Response
     */
    #[Route('/produits', name: 'produits.index', methods: ['GET'])]
    public function index(ProduitsRepository $repository): Response
    {
        return $this->render('pages/produits/index.html.twig', [
            'produits' => $repository->findAll(),
        ]);
    }

    /**
     * This controller shows a form to create a product
     *
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */

     
     #[Route('/produits/nouveau', 'produits.new', methods: ['GET', 'POST'])]
     public function new(EntityManagerInterface $manager, Request $request): Response
     {
         $produit = new Produits();
         $form = $this->createForm(ProduitType::class, $produit);
     
         $form->handleRequest($request);
     
         if ($form->isSubmitted() && $form->isValid()) {
             // Pas besoin de gérer les catégories manuellement, Symfony s'en charge
             $manager->persist($produit);
             $manager->flush();
     
             $this->addFlash('success', 'Votre produit a été créé avec succès !');
     
             return $this->redirectToRoute('produits.index');
         }
     
         return $this->render('pages/produits/new.html.twig', [
             'form' => $form->createView(),
         ]);
     }

    /**
     * This controller shows a form to edit an existing product
     *
     * @param ProduitsRepository $repository
     * @param int $id
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/produits/edition/{id}', 'produits.edit', methods: ['GET', 'POST'])]
    public function edit(
        ProduitsRepository $repository,
        int $id,
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $produit = $repository->find($id);
        if (!$produit) {
            $this->addFlash('error', 'Produit non trouvé');
            return $this->redirectToRoute('produits.index');
        }

        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Ici, on assigne une seule catégorie à un produit
            $categorie = $form->get('categorie')->getData();
            $produit->setCategorie($categorie);

            $manager->flush();

            $this->addFlash('success', 'Votre produit a été modifié avec succès !');

            return $this->redirectToRoute('produits.index');
        }

        return $this->render('pages/produits/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * This controller deletes a product
     *
     * @param EntityManagerInterface $manager
     * @param Produits $produit
     * @return Response
     */
    #[Route('/produits/suppression/{id}', name: 'produits.delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, Produits $produit): Response
    {
        if (!$produit) {
            $this->addFlash('error', 'Produit non trouvé');
            return $this->redirectToRoute('produits.index');
        }

        $manager->remove($produit);
        $manager->flush();

        $this->addFlash('success', 'Votre produit a été supprimé avec succès !');

        return $this->redirectToRoute('produits.index');
    }
}
