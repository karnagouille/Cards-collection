<?php

namespace App\Controller;

use App\Entity\Cartes;
use App\Form\AddCardsType;
use App\Service\ScryfallService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AddCardsController extends AbstractController
{
    //“Si aucun name n’est fourni dans l’URL,alors donne à $name la valeur '' (chaîne vide).
    #[Route('/card/{name}', name: 'card', defaults: ['name' => ''])]
    public function card(string $name, ScryfallService $scryfallService,Request $request,EntityManagerInterface $em): Response
    {
        //Si $name n’est pas vide,alors utilise ce nom pour appeler l’API et récupérer les informations de la carte.”
        if($name !== '') {
            $card = $scryfallService->findcard($name);
        }

        $cartes = new Cartes();

        //“Si on a trouvé une carte, mets son nom,sinon laisse vide.”
        $cartes->setNom(isset($card) ? $card['name'] : '');

        $form = $this->createForm(AddCardsType::class, $cartes);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){

        $cardData = $scryfallService->findcard($cartes->getCardId());

        $cartes->setNom($cardData['name']);
        $cartes->setCouleurs(implode(',', $cardData['colors'] ?? []));
        $cartes->setType($cardData['type_line']);
        $cartes->setCoupEnMana((int) $cardData['cmc']);
        $cartes->setImage($cardData['image_uris']['png']?? '');


            $em->persist($cartes);
            $em->flush();
            return $this->redirectToRoute('card', ['name' => $name]);
        }
        
        return $this->render('add_cards/add_cards.html.twig',[
            'card'=> isset($card) ? $card : null,
            'form'=>$form->createView()
        ]);
    }
}

