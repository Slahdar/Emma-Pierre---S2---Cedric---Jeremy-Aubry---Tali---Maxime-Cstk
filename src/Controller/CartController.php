<?php

namespace App\Controller;

use App\Models\CartModel;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class CartController extends AbstractController
{
    private CartModel $cartModel;
    protected Environment $twig;

    public function __construct(CartModel $cartModel, Environment $twig)
    {
        $this->cartModel = $cartModel;
        $this->twig = $twig;
    }

    public function showCart(): Response
    {
        $cartItems = $this->cartModel->getCartItems();
        $cartTotal = $this->cartModel->getTotal();

        $content = $this->twig->render('cart.twig', [
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal,
        ]);

        return new Response($content);
    }
}
