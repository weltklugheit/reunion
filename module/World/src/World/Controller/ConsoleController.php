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

namespace World\Controller;

use Application\Service\ApplicationService;
use Doctrine\ORM\EntityManager;
use Species\Service\SpeciesService;
use World\Service\GalaxyService;
use World\Service\PlanetarySystemService;
use Zend\Console\Console;
use Zend\Mvc\Controller\AbstractActionController;
use ZendDeveloperTools\Controller\IndexController;

/**
 * Description of IndexController
 *
 * @author heiner
 */
class ConsoleController extends AbstractActionController
{

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * Sets the EntityManager
     *
     * @param  EntityManager   $em
     * @access protected
     * @return IndexController
     */
    protected function setEntityManager(EntityManager $em)
    {
        $this->entityManager = $em;

        return $this;
    }

    /**
     * Returns the EntityManager
     *
     * Fetches the EntityManager from ServiceLocator if it has not been initiated
     * and then returns it
     *
     * @access protected
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        if (null === $this->entityManager) {
            $this->setEntityManager($this->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
        }

        return $this->entityManager;
    }

    public function newAction()
    {
        $console = Console::getInstance();
        $applicationService = $this->getServiceLocator()->get('Application\Service\Application');
        /* @var $applicationService ApplicationService */
        $galaxyService = $this->getServiceLocator()->get('World\Service\Galaxy');
        /* @var $galaxyService GalaxyService */
//        $galaxy = $galaxyService->createRandomGalaxy();
//        $this->getEntityManager()->persist($galaxy);
//        $this->getEntityManager()->flush();
        $galaxy = $this->getEntityManager()->find('World\Entity\Galaxy', 1);

        //$this->getEntityManager()->persist($galaxy);
        $planetarySystemService = $this->getServiceLocator()->get('World\Service\PlanetarySystem');
        /* @var $planetarySystemService PlanetarySystemService */

        for ($index = 0; $index < 10; $index++) {
            $planetarySystem = $planetarySystemService->createRandomPlanetarySystem($galaxy);

            $console->writeLine($index .' create '.$planetarySystem->getName());

            $this->getEntityManager()->persist($planetarySystem);
            $this->getEntityManager()->flush();
        }

        $planetarySystem = $planetarySystemService->createRandomPlanetarySystem($galaxy);
        $this->getEntityManager()->persist($planetarySystem);
        $this->getEntityManager()->flush();

        $speciesService = $this->getServiceLocator()->get('Species\Service\SpeciesService');
        /* @var $speciesService SpeciesService */
        $species = $speciesService->createRandomSpecies();
        $this->getEntityManager()->persist($species);
        $this->getEntityManager()->flush();

        $galaxyService->createMap($galaxy);

        return array(

        );
    }

}
