<?php

namespace Mdespeuilles\WebformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WebformComponent
 *
 * @ORM\Table(name="webform_component")
 * @ORM\Entity(repositoryClass="Mdespeuilles\WebformBundle\Repository\WebformComponentRepository")
 */
class WebformComponent
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="placeholder", type="string", length=255)
     */
    private $placeholder;

    /**
     * @var bool
     *
     * @ORM\Column(name="required", type="boolean")
     */
    private $required;

    /**
     * @var bool
     *
     * @ORM\Column(name="hide_label", type="boolean")
     */
    private $hideLabel;

    /**
     * @var array
     *
     * @ORM\Column(name="extra", type="json_array", nullable=true)
     */
    private $extra;
    
    /**
     * @ORM\ManyToOne(targetEntity="Mdespeuilles\WebformBundle\Entity\Webform", inversedBy="components", cascade={"remove"})
     */
    private $webform;

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return WebformComponent
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
     * Set type
     *
     * @param string $type
     *
     * @return WebformComponent
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set required
     *
     * @param boolean $required
     *
     * @return WebformComponent
     */
    public function setRequired($required)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * Get required
     *
     * @return bool
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * Set extra
     *
     * @param array $extra
     *
     * @return WebformComponent
     */
    public function setExtra($extra)
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * Get extra
     *
     * @return array
     */
    public function getExtra()
    {
        return $this->extra;
    }
    
    /**
     * @return mixed
     */
    public function getWebform() {
        return $this->webform;
    }
    
    /**
     * @param mixed $webform
     */
    public function setWebform($webform) {
        $this->webform = $webform;
    }

    /**
     * @return string
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * @param string $placeholder
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;
    }

    /**
     * @return bool
     */
    public function isHideLabel()
    {
        return $this->hideLabel;
    }

    /**
     * @param bool $hideLabel
     */
    public function setHideLabel($hideLabel)
    {
        $this->hideLabel = $hideLabel;
    }
}

