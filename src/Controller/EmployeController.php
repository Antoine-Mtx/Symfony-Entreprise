<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class EmployeController extends AbstractController
{
    /**
     * @Route("/employe", name="index_employe")
     */

    public function index(PersistenceManagerRegistry $doctrine): Response
    {
        $employes = $doctrine->getRepository(Employe::class)->findAll();

        return $this->render('employe/index.html.twig', [
            'employes' => $employes,
            'controller_name' => 'EmployeController',
        ]);
    }

    /**
     * @Route("/employe/add", name="add_employe")
     * @Route("/employe/update/{id}", name="update_employe")
     */

    public function add(ManagerRegistry $doctrine, Employe $employe = null, Request $request): Response
    {
        if (! $employe) {
            $employe = new Employe();
        }
        $entityManager = $doctrine->getManager(); // permet d'accéder à des méthodes relatives à l'insertion de données dans notre db
        $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employe  = $form->getData();
            $entityManager->persist($employe); // crée une instance de la classe Employe
            $entityManager->flush();

            return $this->redirectToRoute('index_employe');
        }

        return $this->render('employe/add.html.twig', [
            'formEmploye' => $form->createView(),
        ]);
    }

    /**
     * @Route("/employe/delete/{id}", name="delete_employe")
     */

    public function delete(ManagerRegistry $doctrine, Employe $employe)
    {
        $entityManager = $doctrine->getManager(); // permet d'accéder à des méthodes relatives à l'insertion de données dans notre db
        $entityManager->remove($employe); // désigne l'action à éxécuter
        $entityManager->flush(); // enlève l'élément de la base de données
        return $this->redirectToRoute('index_employe');
    }

    /**
     * @Route("/employe/{id}", name="show_employe")
     */

    public function show(Employe $employe): Response
    {
        return $this->render('employe/show.html.twig', [
            'employe' => $employe,
        ]);
    }
}
