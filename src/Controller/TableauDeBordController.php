<?php

namespace App\Controller;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ClientRepository;

class TableauDeBordController extends AbstractController
{
    #[Route('/', name: 'tableau_de_bord')]
    public function index(Request $request, EntityManagerInterface $em, ClientRepository $clientRepository): Response
    {
        $clientRepository = $em->getRepository(Client::class);
        $totalClients = $clientRepository ->createQueryBuilder('a')
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();

        return $this->render('tableau_de_bord/index.html.twig', [
            'controller_name' => 'TableauDeBordController',
        ]);
    }

}
