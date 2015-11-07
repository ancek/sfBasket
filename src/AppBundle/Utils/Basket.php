<?php

namespace AppBundle\Utils;

use AppBundle\Entity\Product;
use ProductNotFoundException;

/**
 * Description of Basket
 *
 * @author ancek74
 */
class Basket
{
    protected $session;
    
    public function __construct($session)
    {
        $this->session = $session;
    }
    
    /**
     * 
     * @param Product $product
     * @return \AppBundle\Utils\Basket
     */
    public function add(Product $product)
    {
        $basket = $this->session->get('basket', []);
        
        if( ! array_key_exists($product->getId(), $basket)) {
            $basket[$product->getId()] = [
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'quantity' => 1
            ];
        } else {
            $basket[$product->getId()]['quantity']++;
        }

        //Aktualizujemy stan koszyka w sesji
        $this->session->set('basket', $basket);
        
        return $this;
    }
    
    /**
     * Usuwanie produktu z koszyka
     * @param Product $product
     * @return \AppBundle\Utils\Basket
     * @throws ProductNotFoundException
     */
    public function remove(Product $product)
    {
        $basket = $this->session->get('basket', []);
        
        if(!array_key_exists($product->getId(), $basket)) {
            throw new ProductNotFoundException('Produkt nie został znaleziony w koszyku');
        }
        
        unset($basket[$product->getId()]);
        
        //Aktualizujemy stan koszyka w sesji
        $this->session->set('basket', $basket);
        
        return $this;
    }
    
    /**
     * 
     * @return \AppBundle\Utils\Basket
     */
    public function clear()
    {
        //aktualizujemy koszyk
        $this->session->set('basket', []);
        
        return $this;
    }
    
    /**
     * 
     * @return array
     */
    public function getProducts()
    {
        return $this->session->get('basket',[]);
    }
    
    public function getTotalAmount()
    {
        return 0;
    }
    
    public function getTotalQuantity()
    {
        return 0;
    }
}
