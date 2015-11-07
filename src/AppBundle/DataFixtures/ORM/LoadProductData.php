<?php

namespace AppBundle\DataFixtires\ORM;

use AppBundle\Entity\Product;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Description of LoadProductData
 *
 * @author ancek74
 */
class LoadProductData extends AbstractFixture implements OrderedFixtureInterface
{
     public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
                
        for($i = 0 ; $i<1000; $i++) {
            
            $product = new Product();
            $product->setName(ucfirst($faker->word));
            $product->setDescription(ucfirst($faker->text));
            $product->setPrice(ucfirst($faker->randomFloat(2, 10, 9999)));
            $product->setAmount(ucfirst($faker->numberBetween(0, 20)));
            $product->setCategory($this->getReference('category-' . $faker->numberBetween(1, 100)));
            
            $manager->persist($product);
        }
        
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }

}
