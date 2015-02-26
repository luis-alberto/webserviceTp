<?php

namespace LAP\WebserviceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Stuff
 *
 * @ORM\MappedSuperclass
 * @ORM\Table()
 *
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\HasLifecycleCallbacks
 */
class Stuff extends BaseEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Serializer\Groups({"detail_perso", "detail_stuff", "list_stuff"})
     */
    protected $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="rarity", type="integer")
     * @Serializer\Groups({"detail_perso", "detail_stuff", "list_stuff"})
     */
    protected $rarity;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer")
     * @Serializer\Groups({"detail_perso", "detail_stuff", "list_stuff"})
     */
    protected $level;

    /**
     * @var integer
     *
     * @ORM\Column(name="weight", type="integer")
     * @Serializer\Groups({"detail_perso", "detail_stuff", "list_stuff"})
     */
    protected $weight;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Perso", inversedBy="stuffs")
     * @ORM\JoinColumn(name="perso_id", referencedColumnName="id")
     * @Serializer\Groups({"detail_stuff"})
     */
    protected $perso;


    /**
     * Set name
     *
     * @param string $name
     * @return Stuff
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
     * Set rarity
     *
     * @param integer $rarity
     * @return Stuff
     */
    public function setRarity($rarity)
    {
        $this->rarity = $rarity;

        return $this;
    }

    /**
     * Get rarity
     *
     * @return integer 
     */
    public function getRarity()
    {
        return $this->rarity;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return Stuff
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
     * Set weight
     *
     * @param integer $weight
     * @return Stuff
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return integer 
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set perso
     *
     * @param \stdClass $perso
     * @return Stuff
     */
    public function setPerso($perso)
    {
        $this->perso = $perso;

        return $this;
    }

    /**
     * Get perso
     *
     * @return \stdClass 
     */
    public function getPerso()
    {
        return $this->perso;
    }
}
