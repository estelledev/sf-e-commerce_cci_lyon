<?php

namespace App\Controller\Frontend;

use App\Entity\OrderItem;
use App\Entity\Produit;
use App\Form\AddToCartType;
use App\Manager\CartManager;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/produits', name: 'app.produits')]
class ProductController extends AbstractController
{
    public function __construct(
        private readonly ProduitRepository $productRepo,
    ) {
    }

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $page = $request->query->get('page', 1);

        return $this->render('Frontend/Produits/index.html.twig', [
            'produits' => $this->productRepo->findListShop($page),
        ]);
    }

    #[Route('/{code}/details', name: '.show', methods: ['GET', 'POST'])]
    public function show(?Produit $produit, Request $request, CartManager $cartManager): Response|RedirectResponse
    {
        if (!$produit) {
            $this->addFlash('error', 'Produit non trouvé');

            return $this->redirectToRoute('app.produits.index');
        }

        $orderItem = new OrderItem;

        $form = $this->createForm(AddToCartType::class, $orderItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On relie l'orderItem au produit
            $orderItem->setProduct($produit);

            // On récupérer le panier ou en créer un nouveau
            $cart = $cartManager->getCurrentCart();

            // On ajoute l'orderItem à la commande
            $cart->addItem($orderItem)
                ->setUpdatedAt(new \DateTimeImmutable);

            // On sauvegarde la commande
            $cartManager->save($cart);

            $this->addFlash('success', 'Produit ajouté au panier');

            return $this->redirectToRoute('app.produits.show', [
                'code' => $produit->getCode(),
            ]);
        }

        return $this->render('Frontend/Produits/show.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }
}
