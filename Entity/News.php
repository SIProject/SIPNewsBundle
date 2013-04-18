<?php
/*
 * (c) Suhinin Ilja <iljasuhinin@gmail.com>
 */
namespace SIP\NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\MappedSuperclass
 */
class News
{
    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $date;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $brief;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="string")
     */
    protected $slug;

    /**
     * @ORM\ManyToOne(targetEntity="SIP\ResourceBundle\Entity\Media\Media", fetch="EAGER")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=true)
     */
    protected $image;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $link;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $onMain;

    /**
     * Set title
     *
     * @param string $title
     * @return News
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return News
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set brief
     *
     * @param string $brief
     * @return News
     */
    public function setBrief($brief)
    {
        $this->brief = $brief;
    
        return $this;
    }

    /**
     * Get brief
     *
     * @return string 
     */
    public function getBrief()
    {
        return $this->brief;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return News
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return News
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return News
     */
    public function setLink($link)
    {
        $this->link = $link;
    
        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set image
     *
     * @param \SIP\ResourceBundle\Entity\Media\Media $image
     * @return News
     */
    public function setImage(\SIP\ResourceBundle\Entity\Media\Media $image = null)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return \SIP\ResourceBundle\Entity\Media\Media 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set onMain
     *
     * @param boolean $onMain
     * @return News
     */
    public function setOnMain($onMain)
    {
        $this->onMain = $onMain;
    
        return $this;
    }

    /**
     * Get onMain
     *
     * @return boolean 
     */
    public function getOnMain()
    {
        return $this->onMain;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->getTitle();
    }
}