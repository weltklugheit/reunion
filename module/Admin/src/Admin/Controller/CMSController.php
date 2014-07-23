<?php

/*
 * The MIT License
 *
 * Copyright 2014 hbaeumer.
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

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * Description of CMSAdminController
 *
 * @author hbaeumer
 */
class CMSController extends AbstractActionController
{

    public function newAction()
    {
        $service = $this->serviceLocator->get('CMS\Service\Post');
        /* @var $service \CMS\Service\PostService */
        $entity = new \CMS\Entity\Post();
        $form = $service->createForm();

        $prg = $this->prg('/admin/cms/new', true);

        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            // returned a response to redirect us
            echo 'returned a response to redirect us';

            return $prg;
        } elseif ($prg === false) {
           // this wasn't a POST request, but there were no params in the flash messenger
           echo 'probably this is the first time the form was loaded';

            return array('form' => $form);
        }

        $form->setData($prg);
        if ($form->isValid()) {

            $entity->exchangeArray($prg);
            $service->create($entity);
        }

        var_dump($entity);

        return array('form' => $form);
    }
}
