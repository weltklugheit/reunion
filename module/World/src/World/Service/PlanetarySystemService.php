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

namespace World\Service;

use Application\Service\NameService;
use World\Entity\StarSystem;

/**
 * Description of PlanetarySystemService
 *
 * @author heiner
 */
class PlanetarySystemService
{
    /**
     *
     * @var NameService 
     */
    protected $nameService;
    
    /**
     *
     * @var \World\Service\StarSystemService
     */
    protected $starSystemService;
    
    /**
     *
     * @var \World\Service\PlanetService
     */
    protected $planetService;
            
    function __construct(NameService $nameService, StarSystemService $starSystemService, PlanetService $planetService)
    {
        $this->nameService = $nameService;
        $this->starSystemService = $starSystemService;
        $this->planetService = $planetService;
    }

    /**
     * 
     * @param \World\Entity\Galaxy $galaxy
     * @return \World\Entity\PlanetarySystem
     */
    public function createRandomPlanetarySystem($galaxy)
    {
        $planetarySystem = new \World\Entity\PlanetarySystem();
        $planetarySystem->setName($this->nameService->createName());
        $planetarySystem->setGalaxy($galaxy);
        $starSystem = $this->starSystemService->createRandomStarSystem($planetarySystem);
        $planetarySystem->setStarSystem($starSystem);
        $planets =  rand (5,12);
        for ($index = 0; $index < $planets; $index++) {
            $planetarySystem->addPlanet($this->planetService->createRandomPlanet($planetarySystem));
        }
        
        $planetarySystem->setCoordinate($this->createRandomCoordinate());
        return $planetarySystem;
    }
    
    protected function createRandomCoordinate()
    {
        $coordx = rand(0,800);
        $coordy = rand(0,1024);
        $coordz = 0;
        $coordinate = $coordx.'.'.$coordy.'.'.$coordz;
        return $coordinate;
    }
    
    
}
