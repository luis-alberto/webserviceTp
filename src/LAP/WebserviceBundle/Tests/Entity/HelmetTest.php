<?php

namespace LAP\WebserviceBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use LAP\WebserviceBundle\Entity\Perso;
use LAP\WebserviceBundle\Entity\Helmet;

class HelmetTest extends WebTestCase {
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
     * Create helmet.
     * @return number
     */
    private function newHelmet(){
        $em = $this->getEntityManager ();
        $perso = new Perso();
        $perso->setName("name");
        $perso->setClass("class");
        $perso->setLevel(1);
        $perso->setRace("race");
        $perso->setSexe("sex");
        $em->persist ( $perso );
        $em->flush ();
        $helmet = new Helmet();
        $helmet->setName("NameTestNew");
        $helmet->setPerso($perso);
        $helmet->setLevel(1);
        $helmet->setRarity(1);
        $helmet->setWeight(1);
        $em->persist ( $helmet );
        $em->flush ();
        $idHelmet = $helmet->getId ();

        return $idHelmet;
    }
    /**
     * Test create new helmet.
     */
    public function testNewHelmet() {
        $em = $this->getEntityManager ();
        $idHelmet = $this->newHelmet();
        $helmetVerif = $em->getRepository ( 'LAPWebserviceBundle:Helmet' )->findOneById ( $idHelmet );
        $this->assertEquals ( $helmetVerif->getName (), "NameTestNew" );
        $this->assertEquals ( $helmetVerif->getLevel (), 1 );
        $this->assertEquals ( $helmetVerif->getRarity (), 1 );
        $this->assertEquals ( $helmetVerif->getWeight (), 1 );
    }
    /**
     * Test update helmet.
     */
    public function testUpdateHelmet() {
        $em = $this->getEntityManager ();
        $idHelmet = $this->newHelmet();
        $helmet = $em->getRepository ( 'LAPWebserviceBundle:Helmet' )->findOneById ( $idHelmet );
        $dateUpdated = $helmet->getUpdatedAt();
        $helmet->setName("NameTestUpdate");
        $helmet->setLevel ( 2 );
        $helmet->setRarity ( 3 );
        $helmet->setWeight ( 4 );
        $helmet->setUpdatedAt(new \DateTime('now'));
        $em->persist ( $helmet );
        $em->flush ();
        
        $helmetVerif = $em->getRepository ( 'LAPWebserviceBundle:Helmet' )->findOneById ( $idHelmet);
        
        $this->assertEquals ( $helmetVerif->getName (), "NameTestUpdate" );
        $this->assertEquals ( $helmetVerif->getLevel (), 2 );
        $this->assertEquals ( $helmetVerif->getRarity (), 3 );
        $this->assertEquals ( $helmetVerif->getWeight (), 4 );
        $this->assertEquals ( $helmetVerif->getUpdatedAt (), $dateUpdated );
    }
    /**
     * Test remove helmet.
     */
    public function testRemovehelmet() {
        $em = $this->getEntityManager ();
        $idHelmet = $this->newHelmet();
        $helmet = $em->getRepository ( 'LAPWebserviceBundle:Helmet' )->findOneById ( $idHelmet );
        $em->remove ( $helmet );
        $em->flush ();
        
        $helmetRemoved = $em->getRepository ( 'LAPWebserviceBundle:Helmet' )->findOneById ( $idHelmet );
        $this->assertNull ( $helmetRemoved );
    }
}