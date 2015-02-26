<?php

namespace LAP\WebserviceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use LAP\WebserviceBundle\Entity\Boot;
use LAP\WebserviceBundle\Entity\Perso;

class LoadBootData extends AbstractFixture implements OrderedFixtureInterface {
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $faker = Faker\Factory::create();
        for ($i = 1; $i <= 40; $i ++) {
            $boot = new Boot();
            $boot->setName($faker->streetName);
            $perso = $this->getReference('perso-'.rand(1,50));
            $boot->setPerso($perso);
            $boot->setLevel(rand(0,20));
            $boot->setRarity(rand(1,10));
            $boot->setWeight(rand(1,200));
            $manager->persist ( $boot );
            $manager->flush ();
        }
    }
    public function getOrder()
    {
        return 3;
    }
}