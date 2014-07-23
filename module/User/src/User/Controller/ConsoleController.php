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

namespace User\Controller;

use Doctrine\ORM\EntityManager;
use RuntimeException;
use Zend\Console\ColorInterface;
use Zend\Console\Console;
use Zend\Console\Request;
use Zend\Mvc\Controller\AbstractActionController;
use ZfcUser\Service\User as UserService;

/**
 * Description of IndexController
 *
 * @author heiner
 */
class ConsoleController extends AbstractActionController
{

    /**
     * @var UserService
     */
    protected $userService;

    public function createAdminAction()
    {
        $console = Console::getInstance();
        $request = $this->getRequest();
        if (!$request instanceof Request) {
            throw new RuntimeException('You can only use this action from a console!');
        }

        $console->showCursor();
        $console->write('password: ');
        $password       = $this->getPassword(true);
        $console->writeLine();
        $console->write('passwordVerify: ');
        $passwordVerify = $this->getPassword(true);
        $console->writeLine();
        $roleId         = $request->getParam('role');
        $email          = $request->getParam('email');

        $entityManager  = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        /* @var $entityManager EntityManager */
        $roleRepository = $entityManager->getRepository('User\Entity\Role');
        $userRepository = $entityManager->getRepository('User\Entity\User');
        $role           = $roleRepository->findOneBy(array('roleId' => $roleId));
        if (!$role) {
            $console->writeLine('No Role', ColorInterface::RED);
        }

        $data    = array(
            'email'          => $email,
            'password'       => $password,
            'passwordVerify' => $passwordVerify,
        );
        $service = $this->getUserService();

        $class = $service->getOptions()->getUserEntityClass();
        $user  = new $class;
        $form  = $service->getRegisterForm();
        $form->setHydrator($service->getFormHydrator());
        $form->bind($user);
        $form->setData($data);
        if (!$form->isValid()) {
            foreach ($form->getMessages() as $key => $value) {
                $message = \array_values($value);
                $console->writeLine($key . ': ' . $message[0], ColorInterface::RED);
            }
        }

        $user = $service->register($data);
        if ($user instanceof \User\Entity\User) {

            $user->addRole($role);

            $entityManager->persist($user);

            $entityManager->flush();
        }
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

    /**
     * Getters/setters for DI stuff
     */
    public function getUserService()
    {
        if (!$this->userService) {
            $this->userService = $this->getServiceLocator()->get('zfcuser_user_service');
        }

        return $this->userService;
    }

    public function setUserService(UserService $userService)
    {
        $this->userService = $userService;

        return $this;
    }

}
