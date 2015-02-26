<?php

namespace LAP\WebserviceBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use LAP\WebserviceBundle\Entity\Boot;
use LAP\WebserviceBundle\Entity\Perso;

class BootTest extends WebTestCase {
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
     * Create boot.
     * @return number
     */
    private function newBoot(){
        $em = $this->getEntityManager ();
        $perso = new Perso();
        $perso->setName("name");
        $perso->setClass("class");
        $perso->setLevel(1);
        $perso->setRace("race");
        $perso->setSexe("sex");
        $em->persist ( $perso );
        $em->flush ();
        $boot = new Boot();
        $boot->setName("NameTestNew");
        $boot->setPerso($perso);
        $boot->setLevel(1);
        $boot->setRarity(1);
        $boot->setWeight(1);
        $em->persist ( $boot );
        $em->flush ();
        $idboot = $boot->getId ();

        return $idboot;
    }
    /**
     * Test create boot.
     */
    public function testNewBoot() {
        $em = $this->getEntityManager ();
        $idboot = $this->newBoot();
        $bootVerif = $em->getRepository ( 'LAPWebserviceBundle:Boot' )->findOneById ( $idboot );
        $this->assertEquals ( $bootVerif->getName (), "NameTestNew" );
        $this->assertEquals ( $bootVerif->getLevel (), 1 );
        $this->assertEquals ( $bootVerif->getRarity (), 1 );
        $this->assertEquals ( $bootVerif->getWeight (), 1 );
    }
    /**
     * Test update Boot.
     */
    public function testUpdateBoot() {
        $em = $this->getEntityManager ();
        $idboot = $this->newBoot();
        $boot = $em->getRepository ( 'LAPWebserviceBundle:Boot' )->findOneById ( $idboot );
        $dateUpdated = $boot->getUpdatedAt();
        $boot->setName("NameTestUpdate");
        $boot->setLevel ( 2 );
        $boot->setRarity ( 3 );
        $boot->setWeight ( 4 );
        $boot->setUpdatedAt(new \DateTime('now'));
        $em->persist ( $boot );
        $em->flush ();
        
        $bootVerif = $em->getRepository ( 'LAPWebserviceBundle:Boot' )->findOneById ( $idboot);
        
        $this->assertEquals ( $bootVerif->getName (), "NameTestUpdate" );
        $this->assertEquals ( $bootVerif->getLevel (), 2 );
        $this->assertEquals ( $bootVerif->getRarity (), 3 );
        $this->assertEquals ( $bootVerif->getWeight (), 4 );
        $this->assertEquals ( $bootVerif->getUpdatedAt (), $dateUpdated );
    }
    /**
     * Test remove boot.
     */
    public function testRemoveBoot() {
        $em = $this->getEntityManager ();
        $idboot = $this->newBoot();
        $boot = $em->getRepository ( 'LAPWebserviceBundle:Boot' )->findOneById ( $idboot );
        $em->remove ( $boot );
        $em->flush ();
        
        $bootRemoved = $em->getRepository ( 'LAPWebserviceBundle:Boot' )->findOneById ( $idboot );
        $this->assertNull ( $bootRemoved );
    }
}