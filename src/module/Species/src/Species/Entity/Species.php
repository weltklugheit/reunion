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

namespace Species\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Species
 * @ORM\Entity
 * @ORM\Table(name="species")
 * @author heiner
 */
class Species
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     */
    protected $name;
    
    /**
     *
     * @var \World\Entity\World
     * @ORM\ManyToOne(targetEntity="World\Entity\World", inversedBy="species")
     */
    protected $world;
    
    /**
     *
     * @var \Species\Entity\Individual[]
     * @ORM\OneToMany(targetEntity="Species\Entity\Individual", mappedBy="species")
     */
    protected $individuals;
    
       
    
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getWorld()
    {
        return $this->world;
    }

    public function getIndividuals()
    {
        return $this->individuals;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setWorld(\World\Entity\World $world)
    {
        $this->world = $world;
    }

    public function setIndividuals(\Species\Entity\Individual $individuals)
    {
        $this->individuals = $individuals;
    }


}
