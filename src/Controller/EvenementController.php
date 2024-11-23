<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Utilisateur;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Form\Type\VichFileType;

#[Route('/evenement')]
class EvenementController extends AbstractController
{
    #[Route('/index', name: 'app_evenement_index', methods: ['GET'])]
    public function index(EvenementRepository $evenementRepository): Response
    {
        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
       
    }


    #[Route('/front', name: 'app_evenement_front', methods: ['GET'])]
    public function front(EvenementRepository $evenementRepository): Response
    {
        return $this->render('baseFront.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
       
    }

    #[Route('/new', name: 'app_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EvenementRepository $evenementRepository): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
    
            if ($evenement->getImageFile()) {
                $evenement->setUpdatedAt(new \DateTime('now'));
            }
    
            $entityManager->persist($evenement);
            $entityManager->flush();

    
            $this->addFlash('success', 'L\'événement a été créé avec succès.');
            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);

        }
     
    
        return $this->render('evenement/new.html.twig', [
            'form' => $form->createView(),
        ]); 
     
    }



    #[Route('/{id}', name: 'app_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }
    
    #[Route('/{id}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(UtilisateurRepository $utilisateurRepository,MailerInterface $mailer,Request $request, Evenement $evenement, EvenementRepository $evenementRepository): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evenementRepository->save($evenement, true);
            $users = $utilisateurRepository->findAll();
            $email = (new Email())
                ->from('soucrafribogri@testMail.com')
                ->subject('Modification évènement')
                ->html('<html><body><h1>Nous vous informons que l evenement à été modifier. </h1><p>Merci de visiter nos évènements!</p></body></html>');
            foreach ($users as $user) {
                $email->addTo($user->getEmail());
            }
            $mailer->send($email);
            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EvenementRepository $evenementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $evenementRepository->remove($evenement, true);
            
        }


        return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route("/front/event_affiche", name: "app_evenement_nouveau", methods: ["GET","POST"])]
    public function nouveau(Request $request): Response
    {
        // Créer un nouvel objet Evenement à partir des données du formulaire
        $evenement = new Evenement();
        $evenement->setId($request->request->get('id'));
        $evenement->setTitre($request->request->get('titre'));
        $evenement->setImage($request->request->get('image'));
        $evenement->setDate(new \DateTime($request->request->get('date')));
        $evenement->setLieu($request->request->get('lieu'));

        // Enregistrer l'objet Evenement dans la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($evenement);
        $entityManager->flush();

        // Rediriger l'utilisateur vers la page d'affichage de l'événement
        return $this->redirectToRoute('app_front_event_affiche', ['id' => $evenement->getId()]);
    }

    
}
