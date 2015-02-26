<?php

namespace LAP\WebserviceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use LAP\WebserviceBundle\Entity\Register;

class LoadRegisterData extends AbstractFixture implements OrderedFixtureInterface {
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        for ($i = 1; $i <= 60; $i ++) {
            $register = new Register();
            $register->setGuild($this->getReference('guild-'.rand(1,30)));
            $register->setPerso($this->getReference('perso-'.rand(1,50)));
            $register->setLevel(rand(0,20));
            $register->setRang(rand(1,20));
            $manager->persist ( $register );
            $manager->flush ();
        }
    }
    public function getOrder()
    {
        return 2;
    }
}