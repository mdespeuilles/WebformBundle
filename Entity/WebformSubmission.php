<?php

namespace Mdespeuilles\WebformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * WebformSubmission
 *
 * @ORM\Table(name="webform_submission")
 * @ORM\Entity(repositoryClass="Mdespeuilles\WebformBundle\Repository\WebformSubmissionRepository")
 */
class WebformSubmission
{
    use TimestampableEntity;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var array
     *
     * @ORM\Column(name="data", type="json_array")
     */
    private $data;
    
    /**
     * @ORM\ManyToOne(targetEntity="Mdespeuilles\WebformBundle\Entity\Webform", cascade={"remove"})
     */
    private $webform;


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
     * Set data
     *
     * @param array $data
     *
     * @return WebformSubmission
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
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
}

