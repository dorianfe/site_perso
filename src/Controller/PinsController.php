<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Repository\PinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Doctrine\ORM\EntityManagerInterface;

class PinsController extends AbstractController
{
    #[Route('/pins', name: 'app_pins', methods: ['GET'])]
    public function index(pinRepository $pinRepository): Response
    {

        $pins = $pinRepository->findBy([], ['createdAt' => 'DESC']);
        
        return $this->render('pins/index.html.twig', compact('pins'));
    }

    #[Route('/pins/{id<[0-9]+>}', name: 'app_pins_show', methods: ['GET'])]
    public function show(Pin $pin): Response
    {
        return $this->render('pins/show.html.twig', compact('pin'));
    }

    #[Route('/pins/create', name: 'app_pins_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $pin = new Pin;

        $form = $this->createFormBuilder($pin)
        ->add('title', TextType::class)
        ->add('description', TextareaType::class)
        ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            //$pin = $form->getData(); either getData or $pin
            // In place of creating a new pin a Pin Oject can be injected in createFormBuilder(new Pin) or $pin with attribute set to null
            //$pin = new Pin;
            //$pin->setTitle($data['title']);
            //$pin->setDescription($data['description']);
            $em->persist($pin);
            $em->flush();

            return $this->redirectToRoute('app_pins');
        }
        
        return $this->render('pins/create.html.twig', [
            'form'=> $form->createView()
        ]);
    }


    #[Route('/pins/{id<[0-9]+>}/edit', name: 'app_pins_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pin $pin, EntityManagerInterface $em): Response
    {
        $form = $this->createFormBuilder($pin)
        ->add('title', TextType::class)
        ->add('description', TextareaType::class)
        ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
           
            $em->flush();

            return $this->redirectToRoute('app_pins');
        }


        return $this->render('pins/edit.html.twig', [
            'pin' => $pin,
            'form' => $form->createView()
        ]);
    }

}
