<?php

namespace LAP\WebserviceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use LAP\WebserviceBundle\Entity\Perso;
use Faker;

class LoadPersoData extends AbstractFixture implements OrderedFixtureInterface{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $faker = Faker\Factory::create ();
        for($i = 1; $i <= 50; $i ++) {
            $perso = new Perso ();
            $perso->setName ( $faker->userName );
            $perso->setLevel(rand(1,20));
            if (rand ( 0, 1 )) {
                $perso->setSexe ( 'Male' );
            } else {
                $perso->setSexe ( 'Female' );
            }
            switch (rand ( 0, 4 )) {
                case 0 :
                    $perso->setRace ( 'Human' );
                    break;
                case 1 :
                    $perso->setRace ( 'Elf' );
                    break;
                case 2 :
                    $perso->setRace ( 'Troll' );
                    break;
                case 3 :
                    $perso->setRace ( 'Hobbit' );
                    break;
                case 4 :
                    $perso->setRace ( 'Goblin' );
                    break;
            }
            switch (rand ( 0, 4 )) {
                case 0 :
                    $perso->setClass ( 'Shaman' );
                    break;
                case 1 :
                    $perso->setClass ( 'Paladin' );
                    break;
                case 2 :
                    $perso->setClass ( 'Mage' );
                    break;
                case 3 :
                    $perso->setClass ( 'Warrior' );
                    break;
                case 4 :
                    $perso->setClass ( 'Hunter' );
                    break;
            }
            $manager->persist ( $perso );
            $manager->flush ();
            
            $this->addReference('perso-'.$i, $perso);
        }
    }
    public function getOrder()
    {
        return 0;
    }
}