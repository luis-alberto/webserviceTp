<?php

namespace LAP\WebserviceBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use LAP\WebserviceBundle\Entity\Perso;
use LAP\WebserviceBundle\Entity\LAP\WebserviceBundle\Entity;

class GuildTest extends WebTestCase {
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
     * Create perso.
     * @return number
     */
    private function newPerso(){
        $em = $this->getEntityManager ();
        $perso = new Perso ();
        $perso->setName ( 'PersoTestNew' );
        $perso->setClass ( "ClassTestNew" );
        $perso->setLevel ( 1 );
        $perso->setRace ( "RaceTestNew" );
        $perso->setSexe ( "SexTestNew" );
        $em->persist ( $perso );
        $em->flush ();
        $idPerso = $perso->getId ();

        return $idPerso;
    }
    /**
     * Test create perso.
     */
    public function testNewPerso() {
        $em = $this->getEntityManager ();
        $idPerso = $this->newPerso();
        $persoVerif = $em->getRepository ( 'LAPWebserviceBundle:Perso' )->findOneById ( $idPerso );
        $this->assertEquals ( $persoVerif->getName (), "PersoTestNew" );
        $this->assertEquals ( $persoVerif->getClass (), "ClassTestNew" );
        $this->assertEquals ( $persoVerif->getLevel (), 1 );
        $this->assertEquals ( $persoVerif->getRace (), "RaceTestNew" );
        $this->assertEquals ( $persoVerif->getSexe (), "SexTestNew" );
    }
    /**
     * Test update perso.
     */
    public function testUpdatePerso() {
        $em = $this->getEntityManager ();
        $idPerso = $this->newPerso();
        $perso = $em->getRepository ( 'LAPWebserviceBundle:Perso' )->findOneById ( $idPerso );
        $dateUpdated = $perso->getUpdatedAt();
        $perso->setName ( 'PersoTestUpdate' );
        $perso->setClass ( "ClassTestUpdate" );
        $perso->setUpdatedAt(new \DateTime('now'));
        $perso->setLevel ( 2 );
        $perso->setRace ( "RaceTestUpdate" );
        $perso->setSexe ( "SexTestUpdate" );
        $em->persist ( $perso );
        $em->flush ();
        
        $persoVerif = $em->getRepository ( 'LAPWebserviceBundle:Perso' )->findOneById ( $idPerso);
        
        $this->assertEquals ( $persoVerif->getName (), "PersoTestUpdate" );
        $this->assertEquals ( $persoVerif->getClass (), "ClassTestUpdate" );
        $this->assertEquals ( $persoVerif->getUpdatedAt (), $dateUpdated );
        $this->assertEquals ( $persoVerif->getLevel (), 2 );
        $this->assertEquals ( $persoVerif->getRace (), "RaceTestUpdate" );
        $this->assertEquals ( $persoVerif->getSexe (), "SexTestUpdate" );
    }
    /**
     * Test remove perso.
     */
    public function testRemovePerso() {
        $em = $this->getEntityManager ();
        $idPerso = $this->newPerso();
        $perso = $em->getRepository ( 'LAPWebserviceBundle:Perso' )->findOneById ( $idPerso );
        $em->remove ( $perso );
        $em->flush ();
        
        $persoRemove = $em->getRepository ( 'LAPWebserviceBundle:Perso' )->findOneById ( $idPerso );
        $this->assertNull ( $persoRemove );
    }
}