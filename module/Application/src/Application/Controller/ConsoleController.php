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

namespace Application\Controller;

use User\Entity\User;
use Zend\Console\Console;
use Zend\Console\Request;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Description of IndexController
 *
 * @author heiner
 */
class ConsoleController extends AbstractActionController
{

    public function createAdminAction()
    {
        $console = Console::getInstance();
        $request = $this->getRequest();
        if (!$request instanceof Request) {
            throw new \RuntimeException('You can only use this action from a console!');
        }

        $console->showCursor();
        $console->write('password: ');

        $password = $this->getPassword(true);
        $roleId     = $request->getParam('role');

        $entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        /* @var $entityManager \Doctrine\ORM\EntityManager */
        $roleRepository = $entityManager->getRepository('User\Entity\Role');
        $role = $roleRepository->findOneBy(array('roleId'=>$roleId));

        var_dump($role);

        $email    = $request->getParam('email');
        $user     = new User();
        $user->setEmail($email);
        $user->addRole($role);
        $user->setPassword($password);

    }

    protected function getPassword($stars = false)
    {
        // Get current style
        $oldStyle = shell_exec('stty -g');

        if ($stars === false) {
            shell_exec('stty -echo');
            $password = rtrim(fgets(STDIN), "\n");
        } else {
            shell_exec('stty -icanon -echo min 1 time 0');

            $password = '';
            while (true) {
                $char = fgetc(STDIN);

                if ($char === "\n") {
                    break;
                } elseif (ord($char) === 127) {
                    if (strlen($password) > 0) {
                        fwrite(STDOUT, "\x08 \x08");
                        $password = substr($password, 0, -1);
                    }
                } else {
                    fwrite(STDOUT, "*");
                    $password .= $char;
                }
            }
        }

        // Reset old style
        shell_exec('stty ' . $oldStyle);

        // Return the password
        return $password;
    }
}
