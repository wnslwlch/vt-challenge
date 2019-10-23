<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ConfigRepository;
use Symfony\Component\HttpFoundation\Request;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin_index")
     */
    public function admin(ConfigRepository $configRepository): Response
    {

        return $this->render('admin/index.html.twig', ['keys' => $configRepository->findAll() ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/adminConfig", name="admin_config", methods={"POST"})
     */
    public function adminConfig(Request $request, ConfigRepository $configRepository): Response
    {

        $submittedToken = $request->request->get('token');

        if ($this->isCsrfTokenValid('admin-config-token', $submittedToken)) {

            foreach($request->request->all() as $k => $v) {

                if ($config = $configRepository->find($k) ) {

                    $config->setCvalue($v);
                }
            }

            $this->getDoctrine()->getManager()->flush();

        }

        return $this->redirectToRoute('admin_index');
    }
}
