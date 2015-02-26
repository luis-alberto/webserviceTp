<?php

namespace LAP\WebserviceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;

/**
 * Perso
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Perso extends BaseEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Serializer\Groups({"detail_perso","list_perso","detail_guild","detail_stuff"})
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer")
     * @Serializer\Groups({"detail_perso","list_perso","detail_guild","detail_stuff"})
     */
    private $level;

    /**
     * @var string
     *
     * @ORM\Column(name="class", type="string", length=255)
     * @Serializer\Groups({"detail_perso","list_perso","detail_guild","detail_stuff"})
     */
    private $class;

    /**
     * @var string
     *
     * @ORM\Column(name="race", type="string", length=255)
     * @Serializer\Groups({"detail_perso","list_perso","detail_guild","detail_stuff"})
     */
    private $race;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=255)
     * @Serializer\Groups({"detail_perso","list_perso","detail_guild","detail_stuff"})
     */
    private $sexe;

    /**
     * @var \stdClass
     *
     * @ORM\OneToMany(targetEntity="Stuff", mappedBy="perso")
     * @Serializer\Groups({"detail_perso"})
     */
    private $stuffs;

    /**
     * @var \stdClass
     *
     * @ORM\OneToMany(targetEntity="Register", mappedBy="perso")
     */
    private $registers;

    public function __construct()
    {
        $this->registers = new ArrayCollection();
        $this->stuffs = new ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Perso
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return Perso
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set class
     *
     * @param string $class
     * @return Perso
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return string 
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set race
     *
     * @param string $race
     * @return Perso
     */
    public function setRace($race)
    {
        $this->race = $race;

        return $this;
    }

    /**
     * Get race
     *
     * @return string 
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     * @return Perso
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string 
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Add stuffs
     *
     * @param \stdClass $stuffs
     * @return Perso
     */
    public function addStuff(Stuff $stuff)
    {
        $stuff->setPerso($this);
        
        if (!$this->stuffs->contains($stuff)) {
            $this->stuffs->add($stuff);
        }
        
        return $this;
    }

    /**
     * Get stuffs
     *
     * @return \stdClass 
     */
    public function getStuffs()
    {
        return $this->stuffs;
    }

    /**
     * Add registers
     *
     * @param \stdClass $registers
     * @return Perso
     */
    public function addRegister(Register $register)
    {
        $register->setPerso($this);
        
        if (!$this->registers->contains($register)) {
            $this->registers->add($register);
        }
        
        return $this;
    }

    /**
     * Get registers
     *
     * @return \stdClass 
     */
    public function getRegisters()
    {
        return $this->registers;
    }
    
    /**
     * Get name of perso
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
