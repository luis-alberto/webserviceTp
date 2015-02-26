<?php

namespace LAP\WebserviceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use LAP\WebserviceBundle\Entity\Helmet;

class LoadHelmetData extends AbstractFixture implements OrderedFixtureInterface {
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $faker = Faker\Factory::create();
        for ($i = 1; $i <= 40; $i ++) {
            $helmet = new Helmet();
            $helmet->setName($faker->streetName);
            $helmet->setPerso($this->getReference('perso-'.rand(1,50)));
            $helmet->setLevel(rand(0,20));
            $helmet->setRarity(rand(1,10));
            $helmet->setWeight(rand(1,200));
            $manager->persist ( $helmet );
            $manager->flush ();
        }
    }
    public function getOrder()
    {
        return 4;
    }
}