<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ProductController extends Controller
{

    /**
     * @Route("/list", name="product_list")
     */
    public function listAction()
    {
        $products = $this->getProducts();
        
        return $this->render('product/list.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/{id}/add-to-cart", name="product_add_to_cart")
     * @Template()
     */
    public function addToCartAction($id)
    {
        if( ! $product = $this->getProduct($id)) {
            throw $this->createNotFoundException("Produkt nie został znaleziony");
        }
        
        //Pobieramy usługę sesji
        $session = $this->get('session');

        //Jeżeli parametr nie istnieje zwróci nam tablicę
        $basket = $session->get('basket', []);
        
        if( ! array_key_exists($id, $basket)) {
            $basket[$id] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => 1
            ];
        } else {
            $basket[$id]['quantity']++;
        }

        //Aktualizujemy stan koszyka w sesji
        $session->set('basket', $basket);
        
        $this->addFlash('success', 'Produkt został pomyślnie dodany do koszyka');
        
        return $this->redirectToRoute('product_basket');
        
    }

    /**
     * @Route("/basket", name="product_basket")
     */
    public function basketAction()
    {
        $products = $this->get('session')->get('basket', []);
        
        return $this->render('product/basket.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/{id}/remove-from-cart", name="product_remove_form_cart")
     */
    public function removeFromCartAction($id)
    {
        //Pobieramy usługę sesji
        $session = $this->get('session');
        $session->remove('basket', $id);
        
        return $this->redirectToRoute('product_basket');
    }

    /**
     * @Route("/clearBasket")
     * @Template()
     */
    public function clearBasketAction()
    {
        return array(
                // ...
        );
    }
    
    private function getProducts()
    {
        $file = file('product.txt');
        $products = [];
        foreach ($file as $p) {
            $e = explode(':', trim($p));
            $products[$e[0]] = array(
                'id' => $e[0],
                'name' => $e[1],
                'price' => $e[2],
                'description' => $e[3],
            );
        }

        return $products;
    }

    private function getProduct($id)
    {
        $products = $this->getProducts();
        
        if(array_key_exists($id, $products)) {
            return $products[$id];
        }
        
        return null;
    }
    
}
