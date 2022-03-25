<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Repository\PinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PinsController extends AbstractController
{
    #[Route('/pins', name: 'app_pins')]
    public function index(pinRepository $pinRepository): Response
    {

        $pins = $pinRepository->findAll();
        return $this->render('pins/index.html.twig', compact('pins'));
    }


    #[Route('/pins/{id<[0-9]+>}', name: 'app_pins_show')]
    public function show(Pin $pin): Response
    {
        return $this->render('pins/show.html.twig', compact('pin'));
    }
}
