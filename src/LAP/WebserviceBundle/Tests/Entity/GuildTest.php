<?php

namespace LAP\WebserviceBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use LAP\WebserviceBundle\Entity\LAP\WebserviceBundle\Entity;
use LAP\WebserviceBundle\Entity\Guild;

class PersoTest extends WebTestCase {
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
     * Init guild.
     * @return number
     */
    private function newGuild(){
        $em = $this->getEntityManager ();
        $guild = new Guild();
        $guild->setName ( 'NameTestNew' );
        $guild->setBanner( "BannerTestNew" );
        $em->persist ( $guild );
        $em->flush ();
        $idGuild = $guild->getId ();

        return $idGuild;
    }
    /**
     * Test create guild.
     */
    public function testNewGuild() {
        $em = $this->getEntityManager ();
        $idGuild = $this->newGuild();
        $guildVerif = $em->getRepository ( 'LAPWebserviceBundle:Guild' )->findOneById ( $idGuild );
        $this->assertEquals ( $guildVerif->getName (), "NameTestNew" );
        $this->assertEquals ( $guildVerif->getBanner (), "BannerTestNew" );
    }
    /**
     * Test update guild.
     */
    public function testUpdateGuild() {
        $em = $this->getEntityManager ();
        $idGuild = $this->newGuild();
        $guild = $em->getRepository ( 'LAPWebserviceBundle:Guild' )->findOneById ( $idGuild );
        $dateUpdated = $guild->getUpdatedAt();
        $guild->setName ( 'NameTestUpdate' );
        $guild->setBanner ( "BannerTestUpdate" );
        $guild->setUpdatedAt(new \DateTime('now'));
        $em->persist ( $guild );
        $em->flush ();

        $guildVerif = $em->getRepository ( 'LAPWebserviceBundle:Guild' )->findOneById ( $idGuild);

        $this->assertEquals ( $guildVerif->getName (), "NameTestUpdate" );
        $this->assertEquals ( $guildVerif->getBanner (), "BannerTestUpdate" );
        $this->assertEquals ( $guildVerif->getUpdatedAt (), $dateUpdated );
    }
    /**
     * Test remove guild.
     */
    public function testRemovePerso() {
        $em = $this->getEntityManager ();
        $idGuild = $this->newGuild();
        $guild = $em->getRepository ( 'LAPWebserviceBundle:Guild' )->findOneById ( $idGuild );
        $em->remove ( $guild );
        $em->flush ();

        $guildRemove = $em->getRepository ( 'LAPWebserviceBundle:Guild' )->findOneById ( $idGuild );
        $this->assertNull ( $guildRemove );
    }
}