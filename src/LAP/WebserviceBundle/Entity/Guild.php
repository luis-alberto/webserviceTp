<?php

namespace LAP\WebserviceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;

/**
 * Guild
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Guild extends BaseEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Serializer\Groups({"detail_guild","list_guild"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="banner", type="string", length=255)
     * @Serializer\Groups({"detail_guild","list_guild"})
     */
    private $banner;

    /**
     * @var \stdClass
     *
     * @ORM\OneToMany(targetEntity="Register", mappedBy="guild")
     * @Serializer\Groups({"detail_guild"})
     */
    private $registers;

    /**
     * 
     * Constructor
     */
    public function __construct()
    {
        $this->registers = new ArrayCollection();
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return Guild
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
     * Set banner
     *
     * @param string $banner
     * @return Guild
     */
    public function setBanner($banner)
    {
        $this->banner = $banner;

        return $this;
    }

    /**
     * Get banner
     *
     * @return string 
     */
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * Add register
     *
     * @param \stdClass $registers
     * @return Guild
     */
    public function addRegister(Register $register)
    {
        $register->setGuild($this);
        
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
     * Get name of guild
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
