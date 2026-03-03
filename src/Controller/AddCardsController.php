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
    #[Route('/card', name: 'card')]
public function card(Request $request,ScryfallService $scryfallService,EntityManagerInterface $em): Response
{
    $name = $request->query->get('name', '');

    $card = null;
    $editions = [];

    if (!empty($name)) {

        $card = $scryfallService->findcard($name);

        if ($card) {
            $editions = $scryfallService->findAllEditions($name);
        } else {
            $this->addFlash('error', 'Carte introuvable.');
        }
    }

    $cartes = new Cartes();
    $cartes->setNom($card['name'] ?? '');

    $form = $this->createForm(AddCardsType::class, $cartes, [
        'editions' => $editions,
    ]);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $cartes->setCardId($card['id']);
        $cardData = $scryfallService->findcard($name);

        if ($cardData) {

            $cartes->setNom($cardData['name']);
            $cartes->setCouleurs(implode(',', $cardData['colors'] ?? []));
            $cartes->setType($cardData['type_line']);
            $cartes->setCoupEnMana((int) $cardData['cmc']);
            $cartes->setImage($cardData['image_uris']['png'] ?? '');
            $cartes->setEditions($cardData['set_name']);

            $em->persist($cartes);
            $em->flush();
        }

       return $this->redirectToRoute('card');
    }

    return $this->render('add_cards/add_cards.html.twig', [
        'card' => $card,
        'form' => $form->createView()
    ]);
}
}

