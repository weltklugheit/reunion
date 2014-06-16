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
 * @ORM\Table(name="planets")
 * @author heiner
 */
class Planet extends AstronomicalObject
{
    /**
     *
     * @var PlanetarySystem
     * @ORM\ManyToOne(targetEntity="PlanetarySystem", inversedBy="planets")
     */
    protected $planetarySystem;
    
    /**
     *
     * @var Satellite[]
     * @ORM\OneToMany(targetEntity="Satellite", mappedBy="planet")
     */
    protected $satellites;
    
    /**
     *
     * @var float
     * @ORM\Column(type="float", unique=false, nullable=false)
     */
    protected $radius;
    
    /**
     *
     * @var float
     * @ORM\Column(type="float", unique=false, nullable=false)
     */
    protected $distanceFromSun;
    
    public function getPlanetarySystem()
    {
        return $this->planetarySystem;
    }

    public function getSatellites()
    {
        return $this->satellites;
    }

    public function setPlanetarySystem(PlanetarySystem $planetarySystem)
    {
        $this->planetarySystem = $planetarySystem;
    }

    public function setSatellites(Satellite $satellites)
    {
        $this->satellites = $satellites;
    }
    
    public function getRadius()
    {
        return $this->radius;
    }

    public function getDistanceFromSun()
    {
        return $this->distanceFromSun;
    }

    public function setRadius($radius)
    {
        $this->radius = $radius;
    }

    public function setDistanceFromSun($distanceFromSun)
    {
        $this->distanceFromSun = $distanceFromSun;
    }


    
    


    
   
    
}
