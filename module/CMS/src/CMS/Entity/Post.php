<?php

/*
 * The MIT License
 *
 * Copyright 2014 heiner.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace CMS\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;


/**
 * Description of Post
 * @ORM\Entity
 * @ORM\Table(name="posts")
 * @Annotation\Name("annotation_post")
 * @Annotation\Attributes({"class":"form_horizontal"})
 * @author heiner
 */
class Post
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Exclude
     */
    protected $id;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=false, nullable=false)
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"max":255}})
     * @Annotation\Validator({"name":"Alpha", "options":
     *                                        {"allowWhiteSpace":"true"}})
     * @Annotation\Attributes({"class":"span6"})
     * @Annotation\Options({"label":"Name:"})
     */
    protected $name;
    
    /**
     *
     * @var string 
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"max":255}})
     * @Annotation\Validator({"name":"Alpha", "options":
     *                                        {"allowWhiteSpace":"false"}})
     * @Annotation\Attributes({"class":"span6"})
     * @Annotation\Options({"label":"Url:"})
     */
    protected $url;
    
    /**
     *
     * @var string 
     * @ORM\Column(type="string", length=255, unique=false, nullable=false)
    * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"max":255}})
     * @Annotation\Validator({"name":"Alpha", "options":
     *                                        {"allowWhiteSpace":"true"}})
     * @Annotation\Attributes({"class":"span6"})
     * @Annotation\Options({"label":"Headline:"})
     */
    protected $headline;
    
    /**
     *
     * @var string 
     * @ORM\Column(type="string", length=255, unique=false, nullable=true)
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"max":255}})
     * @Annotation\Validator({"name":"Alpha", "options":
     *                                        {"allowWhiteSpace":"true"}})
     * @Annotation\Attributes({"class":"span6"})
     * @Annotation\Options({"label":"Keyword:"})
     */
    protected $keywords;
    
    /**
     *
     * @var string 
     * @ORM\Column(type="text", unique=false, nullable=false)
     * @Annotation\Type("Zend\Form\Element\Textarea")
     * @Annotation\Required({"required":"true"})
     * @Annotation\Options({"label":"Body:"})
     */
    protected $articleBody;
    
    /**
     *
     * @var string 
     * @ORM\Column(type="datetime", unique=false, nullable=false)
     * @Annotation\Exclude
     */
    protected $dateCreated;
    
    /**
     *
     * @var string 
     * @ORM\Column(type="datetime", unique=false, nullable=false)
     * @Annotation\Exclude
     */
    protected $dateModified;
    
    /**
     *
     * @var string 
     * @ORM\Column(type="datetime", unique=false, nullable=true)
     * @Annotation\Exclude
     */
    protected $datePublished;
    
    /**
     *
     * @var User 
     * @ORM\ManyToOne(targetEntity="User\Entity\User", inversedBy="posts")
     * @Annotation\Exclude
     */
    protected $author;
    
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getHeadline()
    {
        return $this->headline;
    }

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function getArticleBody()
    {
        return $this->articleBody;
    }

    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    public function getDateModified()
    {
        return $this->dateModified;
    }

    public function getDatePublished()
    {
        return $this->datePublished;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function setHeadline($headline)
    {
        $this->headline = $headline;
        return $this;
    }

    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
        return $this;
    }

    public function setArticleBody($articleBody)
    {
        $this->articleBody = $articleBody;
        return $this;
    }

    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    public function setDateModified($dateModified)
    {
        $this->dateModified = $dateModified;
        return $this;
    }

    public function setDatePublished($datePublished)
    {
        $this->datePublished = $datePublished;
        return $this;
    }

        
     /**
     * Now we tell doctrine that before we persist or update we call the updatedTimestamps() function.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateTimestamps()
    {
        $this->setDateModified(new DateTime(date('Y-m-d H:i:s')));

        if($this->getDateCreated() == null)
        {
            $this->setDateCreated(new DateTime(date('Y-m-d H:i:s')));
        }
    }
    
}
