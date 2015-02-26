<?php

namespace LAP\WebserviceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use LAP\WebserviceBundle\Entity\Perso;
use Faker;
use LAP\WebserviceBundle\Entity\Guild;

class LoadGuildData extends AbstractFixture implements OrderedFixtureInterface {
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $faker = Faker\Factory::create ();
        
        for($i = 1; $i <= 30; $i ++) {
            $guild = new Guild ();
            $guild->setName ( $faker->company );
            $guild->setBanner ( $faker->companySuffix );
            $manager->persist ( $guild );
            $manager->flush ();
            $this->addReference('guild-'.$i, $guild);
        }
    }
    public function getOrder()
    {
        return 1; 
    }
}