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

namespace World\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Description of World
 * @ORM\Entity
 * @ORM\Table(name="planetary_systems")
 * @author heiner
 */
class PlanetarySystem extends AstronomicalObject
{
    
    /**
     *
     * @var \World\Entity\Planet[]
     * @ORM\OneToMany(targetEntity="World\Entity\Planet", mappedBy="planetarySystem", cascade={"persist"})
     */
    protected $planets;
    
    /**
     *
     * @var \World\Entity\Galaxy
     * @ORM\ManyToOne(targetEntity="World\Entity\Galaxy", inversedBy="planetarySystems")
     */
    protected $galaxy;
    
    /**
     *
     * @var \World\Entity\StarSystem
     * @ORM\OneToOne(targetEntity="StarSystem", mappedBy="planetarySystem", cascade={"persist"})
     */
    protected $starSystem; 
    
    /**
     *
     * @var string
     * @ORM\Column(type="string", unique=true, nullable=false)
     */
    protected $coordinate;




    public function getPlanets()
    {
        return $this->planets;
    }

    public function getGalaxy()
    {
        return $this->galaxy;
    }

    public function getStarSystem()
    {
        return $this->starSystem;
    }

    public function setPlanets( $planets)
    {
        $this->planets = $planets;
    }
    
    public function addPlanet(\World\Entity\Planet $planet)
    {
        $this->planets[] = $planet;
    }

    public function setGalaxy(\World\Entity\Galaxy $galaxy)
    {
        $this->galaxy = $galaxy;
    }

    public function setStarSystem(\World\Entity\StarSystem $starSystem)
    {
        $this->starSystem = $starSystem;
    }
    
    public function getCoordinate()
    {
        return $this->coordinate;
    }

    public function setCoordinate($coordinate)
    {
        $this->coordinate = $coordinate;
    }




   
}
