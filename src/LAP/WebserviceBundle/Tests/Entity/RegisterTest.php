<?php

namespace LAP\WebserviceBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use LAP\WebserviceBundle\Entity\Register;
use LAP\WebserviceBundle\Entity\Perso;
use LAP\WebserviceBundle\Entity\Guild;

class RegisterTest extends WebTestCase {
    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    public function __construct() {
        self::bootKernel ();
        $this->em = static::$kernel->getContainer ()->get ( 'doctrine.orm.entity_manager' );
    }
    /**
     * Enter description here .
     *
     * ..
     *
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager() {
        return $this->em;
    }
    /**
     * Create registrer.
     * @return number
     */
    private function newRegister(){
        $em = $this->getEntityManager ();
        $perso = new Perso();
        $perso->setName("name");
        $perso->setClass("class");
        $perso->setLevel(1);
        $perso->setRace("race");
        $perso->setSexe("sex");
        $em->persist ( $perso );
        $em->flush ();
        $guild = new Guild();
        $guild->setName("name");
        $guild->setBanner("banner");
        $em->persist ( $guild );
        $em->flush ();
        $register = new Register();
        $register->setLevel(1);
        $register->setRang(1);
        $register->setPerso($perso);
        $register->setGuild($guild);
        $em->persist ( $register );
        $em->flush ();
        $idRegister = $register->getId ();

        return $idRegister;
    }
    /**
     * Test create register.
     */
    public function testNewRegister() {
        $em = $this->getEntityManager ();
        $idRegister = $this->newRegister();
        $registerVerif = $em->getRepository ( 'LAPWebserviceBundle:Register' )->findOneById ( $idRegister );
        $this->assertEquals ( $registerVerif->getLevel (), 1 );
        $this->assertEquals ( $registerVerif->getRang (), 1 );
    }
    /**
     * test update register.
     */
    public function testUpdateregister() {
        $em = $this->getEntityManager ();
        $idRegister = $this->newRegister();
        $register = $em->getRepository ( 'LAPWebserviceBundle:Register' )->findOneById ( $idRegister );
        $dateUpdated = $register->getUpdatedAt();
        $register->setLevel ( 2 );
        $register->setRang ( 3 );
        $register->setUpdatedAt(new \DateTime('now'));
        $em->persist ( $register );
        $em->flush ();
        
        $registerVerif = $em->getRepository ( 'LAPWebserviceBundle:Register' )->findOneById ( $idRegister);
        
        $this->assertEquals ( $registerVerif->getLevel (), 2 );
        $this->assertEquals ( $registerVerif->getRang (), 3 );
        $this->assertEquals ( $registerVerif->getUpdatedAt (), $dateUpdated );
    }
    /**
     * Test remove register.
     */
    public function testRemoveRegister() {
        $em = $this->getEntityManager ();
        $idRegister = $this->newRegister();
        $register = $em->getRepository ( 'LAPWebserviceBundle:Register' )->findOneById ( $idRegister );
        $em->remove ( $register );
        $em->flush ();
        
        $registerRemove = $em->getRepository ( 'LAPWebserviceBundle:Register' )->findOneById ( $idRegister );
        $this->assertNull ( $registerRemove );
    }
}