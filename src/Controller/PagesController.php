<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PlantRepository;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\ConfigRepository;
use Symfony\Component\BrowserKit\Request;

class PagesController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(PlantRepository $plantRepository): Response
    {

        $plants = $plantRepository->findAllByUpdatedAtDesc();

        return $this->render('pages/index.html.twig', [
            "plants" => $plants,
        ]);
    }
}
