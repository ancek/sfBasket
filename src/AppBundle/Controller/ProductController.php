<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{

    /**
     * @Route("/list", name="product_list")
     */
    public function listAction(Request $request)
    {
//        $qb = $this->getDoctrine()
//            ->getRepository('AppBundle:Product')
//            ->createQueryBuilder('p')
//            ->select(['p', 'c'])
//            ->innerJoin('p.category', 'c');
        
//        $qb = $this->getDoctrine()
//            ->getManager()
//            ->createQueryBuilder()
//            ->from('AppBundle:Product', 'p')
//            ->select(['p', 'c'])
//            ->innerJoin('p.category', 'c');
        
        
        $qb = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->createQueryBuilder('p');
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $qb, 
            $request->query->getInt('page', 1)/* page number */,
            10/* limit per page */
        );
        
        return $this->render('product/list.html.twig', [
            'products' => $pagination
         ]);
    }

    /**
     * @Route("/{id}/add-to-cart", name="product_add_to_cart")
     * @Template()
     */
    public function addToCartAction(Product $product = null)
    {
        //Pobieramy usługę sesji
//        $product = $this->getDoctrine()
//            ->getRepository('AppBundle:Product')
//            ->find($id);

        $this->getBasket()
            ->add($product);
        
        $this->addFlash('success', 'Produkt został pomyślnie dodany do koszyka');
        
        return $this->redirectToRoute('product_basket');
        
    }

    /**
     * @Route("/basket", name="product_basket")
     */
    public function basketAction()
    {
        return $this->render('product/basket.html.twig', [
            'basket' => $this->getBasket()
        ]);
    }

    /**
     * @Route("/{id}/remove-from-cart", name="product_remove_form_cart")
     */
    public function removeFromCartAction(Product $product)
    {
        try {
            $this
                ->getBasket()
                ->remove($product);
        
        
        } catch (\AppBundle\Exception\ProductNotFoundException $e) {
            $this->addFlash('error', $e->getMessage());
        }
        
        $this->addFlash('success', 'Produkt został pomyślnie usunięty z koszyka');

        
        return $this->redirectToRoute('product_basket');
    }

    /**
     * @Route("/clearBasket", name="product_basket_clear")
     * @Template()
     */
    public function clearBasketAction()
    {
        $this->getBasket()
            ->clear();
        
        return $this->redirectToRoute('product_basket');
    }
    
    /**
     * 
     * @return type
     */
    public function basketBoxAction()
    {
        return $this->render('product/basketBox.html.twig', [
            'basket' => $this->getBasket()
        ]);
    }
    
    /**
     * 
     * @return \AppBundle\Utils\Basket
     */
    private function getBasket()
    {
        return $this->get('basket');
    }
    
}
