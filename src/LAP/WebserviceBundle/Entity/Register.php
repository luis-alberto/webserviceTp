<?php

namespace LAP\WebserviceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Register
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Register extends BaseEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer")
     * @Serializer\Groups({"detail_guild","detail_register"})
     */
    private $level;

    /**
     * @var integer
     *
     * @ORM\Column(name="rang", type="integer")
     * @Serializer\Groups({"detail_guild","detail_register"})
     */
    private $rang;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Perso", inversedBy="registers")
     * @ORM\JoinColumn(name="perso_id", referencedColumnName="id", onDelete="CASCADE")
     * @Serializer\Groups({"detail_guild","detail_register"})
     */
    private $perso;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Guild", inversedBy="registers")
     * @ORM\JoinColumn(name="guild_id", referencedColumnName="id", onDelete="CASCADE")
     * @Serializer\Groups({"detail_register"})
     */
    private $guild;



    /**
     * Set level
     *
     * @param integer $level
     * @return Register
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
     * Set rang
     *
     * @param integer $rang
     * @return Register
     */
    public function setRang($rang)
    {
        $this->rang = $rang;

        return $this;
    }

    /**
     * Get rang
     *
     * @return integer 
     */
    public function getRang()
    {
        return $this->rang;
    }

    /**
     * Set perso
     *
     * @param \stdClass $perso
     * @return Register
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

    /**
     * Set guild
     *
     * @param \stdClass $guild
     * @return Register
     */
    public function setGuild($guild)
    {
        $this->guild = $guild;

        return $this;
    }

    /**
     * Get guild
     *
     * @return \stdClass 
     */
    public function getGuild()
    {
        return $this->guild;
    }
}
