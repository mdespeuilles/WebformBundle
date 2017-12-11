<?php

namespace Mdespeuilles\WebformBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Webform
 *
 * @ORM\Table(name="webform")
 * @ORM\Entity(repositoryClass="Mdespeuilles\WebformBundle\Repository\WebformRepository")
 */
class Webform
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
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;
    
    /**
     * @var array
     *
     * @ORM\Column(name="mails", type="array", nullable=true)
     */
    private $mails;
    
    /**
     * @ORM\OneToMany(targetEntity="Mdespeuilles\WebformBundle\Entity\WebformComponent", mappedBy="webform", cascade={"remove", "persist"})
     */
    private $components;
    
    /**
     * @var string
     *
     * @ORM\Column(name="submit_string", type="string", length=255)
     */
    private $submitString;

    /**
     * @var string
     *
     * @ORM\Column(name="sender_mail", type="string", length=255)
     */
    private $senderMail;

    /**
     * @var string
     *
     * @ORM\Column(name="confirmation_message", type="text")
     */
    private $confirmationMessage;

    /**
     * @var bool
     *
     * @ORM\Column(name="use_ajax", type="boolean")
     */
    private $useAjax;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="use_captcha", type="boolean")
     */
    private $useCaptcha = false;

    /**
     * @ORM\ManyToOne(targetEntity="Mdespeuilles\MailBundle\Entity\Email")
     */
    private $emailTemplate;

    
    public function __construct() {
        $this->components = new ArrayCollection();
    }
    
    public function __toString() {
        return $this->getName();
    }
    
    public function addComponent(WebformComponent $component)
    {
        $this->components[] = $component;
        $component->setWebform($this);
        
        return $this;
    }
    
    public function removeComponent(WebformComponent $component) {
        $this->components->removeElement($component);
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
     * @return string
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }
    
    /**
     * @return string
     */
    public function getSlug() {
        return $this->slug;
    }
    
    /**
     * @param string $slug
     */
    public function setSlug($slug) {
        $this->slug = $slug;
    }
    
    /**
     * @return mixed
     */
    public function getComponents() {
        return $this->components;
    }
    
    /**
     * @param mixed $components
     */
    public function setComponents($components) {
        $this->components = $components;
    }
    
    /**
     * @return string
     */
    public function getSubmitString() {
        return $this->submitString;
    }
    
    /**
     * @param string $submitString
     */
    public function setSubmitString($submitString) {
        $this->submitString = $submitString;
    }
    
    /**
     * @return mixed
     */
    public function getMails() {
        return $this->mails;
    }
    
    /**
     * @param mixed $mails
     */
    public function setMails($mails) {
        $this->mails = $mails;
    }

    /**
     * @return bool
     */
    public function isUseAjax()
    {
        return $this->useAjax;
    }

    /**
     * @param bool $useAjax
     */
    public function setUseAjax($useAjax)
    {
        $this->useAjax = $useAjax;
    }

    /**
     * @return string
     */
    public function getConfirmationMessage()
    {
        return $this->confirmationMessage;
    }

    /**
     * @param string $confirmationMessage
     */
    public function setConfirmationMessage($confirmationMessage)
    {
        $this->confirmationMessage = $confirmationMessage;
    }

    /**
     * @return mixed
     */
    public function getEmailTemplate()
    {
        return $this->emailTemplate;
    }

    /**
     * @param mixed $emailTemplate
     */
    public function setEmailTemplate($emailTemplate)
    {
        $this->emailTemplate = $emailTemplate;
    }

    /**
     * @return string
     */
    public function getSenderMail()
    {
        return $this->senderMail;
    }

    /**
     * @param string $senderMail
     */
    public function setSenderMail($senderMail)
    {
        $this->senderMail = $senderMail;
    }
    
    /**
     * @return mixed
     */
    public function isUseCaptcha() {
        return $this->useCaptcha;
    }
    
    /**
     * @param mixed $useCaptcha
     */
    public function setUseCaptcha($useCaptcha) {
        $this->useCaptcha = $useCaptcha;
    }
}

