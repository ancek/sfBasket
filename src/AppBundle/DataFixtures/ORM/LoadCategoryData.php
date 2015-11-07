<?php

namespace AppBundle\DataFixtires\ORM;

use AppBundle\Entity\Category;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Description of LoadCategoryData
 *
 * @author ancek74
 */
class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager) 
    {
        $faker = Factory::create();
        
        for($i = 1 ; $i <= 100 ; $i++) {
            $category = new Category();
            $category->setName($faker->sentence(2));
            $manager->persist($category);
            
            $this->addReference('category-' . $i, $category);
        }
        
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }

}
