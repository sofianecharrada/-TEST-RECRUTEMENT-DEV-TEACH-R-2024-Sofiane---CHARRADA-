<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CategoriesController extends AbstractController
{
    /**
     * This controller display all products
     *
     * @param CategoriesRepository $repository
     * @return Response
     */
    #[Route('/categories', name: 'categories.index', methods: ['GET'])]
    public function index(CategoriesRepository $repository): Response
    {
        return $this->render('pages/categories/index.html.twig', [
             'categories' => $repository->findAll()
        ]);
    }

    /**
     * This controller show a form which create a product
     *
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    #[Route('/categories/nouveau', 'categories.new', methods: ['GET', 'POST'])]
    public function new(
        EntityManagerInterface $manager,
        Request $request
    ): Response {
        $categories = new Categories();
        $form = $this->createForm(CategoriesType::class, $categories);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $categories = $form->getData();

            $manager->persist($categories);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre catégorie a été créer avec succés !'
            );

            return $this->redirectToRoute('categories.index');
        }


        return $this->render('pages/categories/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/categories/edition/{id}', 'categories.edit', methods: ['GET', 'POST'])]
    public function edit(
        CategoriesRepository $repository,
        int $id,
        Request $request,
        EntityManagerInterface $manager
        ): Response
    {
        $categories = $repository->findOneBy(["id" => $id]);
        $form = $this->createForm(CategoriesType::class, $categories);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $categories = $form->getData();

            $manager->persist($categories);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre categorie a été modifié avec succés !'
            );

            return $this->redirectToRoute('categories.index');
        }

        return $this->render('pages/categories/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/categories/suppression/{id}', name: 'categories.delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, Categories $categories) : Response
    {   

        if(!$categories){

            $this->addFlash(
                'success',
                'Votre catégorie n\'a pas été trouvé'
            );
    
            return $this->redirectToRoute('categories.index');
        }
        $manager->remove($categories);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre catégorie à été supprimé avec succés'
        );

        return $this->redirectToRoute('categories.index');
    }
}
