<?php

namespace App\Controller;

use App\Entity\Vente;
use App\Form\VenteType;
use App\Repository\VenteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VenteController extends AbstractController
{
    #[Route('/vente', name: 'vente')]
    public function allVente(Request $request, VenteRepository $venteRepository){
        
        $ventes=$venteRepository->findAll();

        return $this->render('vente/listVente.html.twig', array(

            'ventes'=>$ventes

        ));


    }

    #[Route('/ajoutVente', name: 'addVente')]

    public function addVente(Request $request, EntityManagerInterface $em)
    {
        $vente=new Vente();
        $form=$this->createForm(VenteType::class, $vente);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
    
           $em ->persist($vente);
           $em ->flush();

           return $this->redirectToRoute('vente');
  
        }
        return $this->render('vente/addVente.html.twig',array(
            'form'=>$form->createView()

        ));
    }

    #[Route("/editVente/{id<\d+>}", name: "updateVente")]

    public function updateVente(Request $request, Vente $vente, EntityManagerInterface $em)
    {
       
        
        $form=$this->createForm(VenteType::class, $vente);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
           $em->flush();

           return $this->redirectToRoute('vente');
  
        }

        return $this->render('vente/updateVente.html.twig',array(
            'form'=>$form->createView(),
            

        ));
    }

    #[Route("/deleteVente/{id<\d+>}", name : "deleteVente")]

    public function deleteClient(Request $request, Vente $vente, EntityManagerInterface $em)
    {
          $em ->remove($vente);
          $em ->flush();

          return $this->redirectToRoute('vente');

       
    }

}
