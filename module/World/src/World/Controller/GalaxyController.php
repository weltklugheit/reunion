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
use World\Entity\Galaxy;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Description of IndexController
 *
 * @author heiner
 */
class GalaxyController extends AbstractActionController
{

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * Sets the EntityManager
     *
     * @param EntityManager $em
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

    public function indexAction()
    {
        return new ViewModel();
    }

    public function newAction()
    {
        $applicationService = $this->getServiceLocator()->get('Application\Service\Application');
        /* @var $applicationService ApplicationService */
        $galaxyService = $this->getServiceLocator()->get('World\Service\Galaxy');
        /* @var $galaxyService \World\Service\GalaxyService */
//        $galaxy = $galaxyService->createRandomGalaxy();
//        $this->getEntityManager()->persist($galaxy);
//        $this->getEntityManager()->flush();
        $galaxy = $this->getEntityManager()->find('World\Entity\Galaxy', 1);


        //$this->getEntityManager()->persist($galaxy);
        $planetarySystemService = $this->getServiceLocator()->get('World\Service\PlanetarySystem');
        /* @var $planetarySystemService \World\Service\PlanetarySystemService */

        for ($index = 0; $index < 50; $index++) {
            $planetarySystem = $planetarySystemService->createRandomPlanetarySystem($galaxy);
            /* @var $planetarySystem \World\Entity\StarSystem */


            $this->getEntityManager()->persist($planetarySystem);
            $this->getEntityManager()->flush();
        }


        $planetarySystem = $planetarySystemService->createRandomPlanetarySystem($galaxy);
        /* @var $planetarySystem \World\Entity\StarSystem */


        $this->getEntityManager()->persist($planetarySystem);
        $this->getEntityManager()->flush();


        $galaxyService->createMap($galaxy);
        
        

        $objects = $this->getEntityManager()->getRepository('World\Entity\StarSystem')->findAll();
        return array(
            'objects' => $objects,
        );
    }

}
