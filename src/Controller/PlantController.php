<?php
//TODO: Default image for Image2
namespace App\Controller;

use App\Entity\Plant;
use App\Form\PlantType;
use App\Repository\PlantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\ConfigRepository;
use App\Service\ConfigService;
use App\Repository\UserRepository;

/**
 * @Route("/plant")
 */
class PlantController extends AbstractController
{
    /**
     * Retourne les plants d'un user
     * @IsGranted("ROLE_USER")
     * @Route("/", name="plant_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        $plants = $this->getUser()->getPlants();
        $photoCount = count($plants);
        $plantsCount = 0;

        foreach($plants as $p) {
            $plantsCount += $p->getNbPlants();
        }

        $user = $this->getUser();

        return $this->render('plant/index.html.twig', compact(
            'plants',
            'user',
            'photoCount',
            'plantsCount'
        ));
    }

    /**
     * @Route("/new", name="plant_new", methods={"GET","POST"})
     */
    public function new(Request $request, ConfigService $configService): Response
    {

        $now = new \DateTime();
        $eventIsOpen = $configService->dateIsOpen($now);


        if ($eventIsOpen) {

            $plant = new Plant();
            $form = $this->createForm(PlantType::class, $plant);

            //retieve the id of the current user
            $actualUser = $this->getUser();
            //set the organizer with the current user
            $plant->setUser($actualUser);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                /********************************************** */


                //retrive the file send in the request for the first image
                $file = $request->files->get('plant')['image_1'];

                if ($file !== null) {

                    //put the path to the folder that will stock our files in a var
                    $uploads_plant_directory = $this->getParameter('uploads_plant_directory');

                    //create a var to change the name of the file
                    $image1Filename = 'plant_image_1_' . md5(uniqid()) . '.' . $file->guessExtension();

                    //move the file into the folder
                    $file->move(
                        $uploads_plant_directory,
                        $image1Filename
                    );

                    //set the event photo's attribut
                    $plant->setImage1($image1Filename);
                }

                /********************************************** */

                if (isset( $request->files->get('plant')['image_2'])) {

                    //retrive the file send in the request for the seconde image
                    $file = $request->files->get('plant')['image_2'];

                    if ($file !== null) {

                        //put the path to the folder that will stock our files in a var
                        $uploads_plant_directory = $this->getParameter('uploads_plant_directory');

                        //create a var to change the name of the file
                        $image2Filename = 'plant_image_2_' . md5(uniqid()) . '.' . $file->guessExtension();

                        //move the file into the folder
                        $file->move(
                            $uploads_plant_directory,
                            $image2Filename
                        );

                        //set the event photo's attribut
                        $plant->setImage2($image2Filename);
                    }
                }

                /********************************************** */

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($plant);
                $entityManager->flush();

                return $this->redirectToRoute('plant_index');
            }

            return $this->render('plant/new.html.twig', [
                'plant' => $plant,
                'form' => $form->createView(),
            ]);
        }

        else {
            return $this->render('plant/newClosed.html.twig');
        }
    }

    /**
     * @Route("/{id}", name="plant_show", methods={"GET"})
     */
    public function show(Plant $plant): Response
    {
        return $this->render('plant/show.html.twig', [
            'plant' => $plant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="plant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Plant $plant): Response
    {
        $form = $this->createForm(PlantType::class, $plant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('plant_index', [
                'id' => $plant->getId(),
            ]);
        }

        return $this->render('plant/edit.html.twig', [
            'plant' => $plant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="plant_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Plant $plant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($plant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_index');
    }

    /**
     * @Route("/like/{id}", name="plant_like", methods={"GET"})
     */
    public function like(Request $request, Plant $plant): Response
    {

        $plant->setNbLikes( $plant->getNbLikes() + 1 );
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($plant);
        $entityManager->flush();

        return $this->redirectToRoute('app_index');

    }
}
