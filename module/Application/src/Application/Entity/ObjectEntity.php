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

namespace Application\Entity;

use Zend\Filter\StaticFilter;
use Zend\Stdlib\ArraySerializableInterface;

/**
 * Description of ObjectEntity
 *
 * @author heiner
 */
abstract class ObjectEntity implements ArraySerializableInterface
{
    public function exchangeArray(array $array)
    {
        foreach ($array as $key => $value) {
            $getMethod = $this->buildMethodName($key, 'get');

            if (!method_exists($this, $getMethod)) {
                continue;
            }

            $setMethod = $this->buildMethodName($key, 'set');

            if (!method_exists($this, $setMethod)) {
                continue;
            }

            if (is_object($this->$getMethod())) {

                $this->$getMethod()->exchangeArray($value);
            } else {
                $this->$setMethod($value);
            }
        }
    }

    public function getArrayCopy()
    {
        $array = array();
        foreach (array_keys(get_object_vars($this)) as $key) {
            $getMethod = $this->buildMethodName($key, 'get');
            if (!method_exists($this, $getMethod)) {
                continue;
            }
            if (is_object($this->$getMethod())) {
                $array[$key] = $this->$getMethod()->getArrayCopy();
            } elseif (is_array($this->$getMethod())) {
                foreach ($this->$getMethod() as $childKey => $childValue) {
                    if (is_object($childValue)) {
                        $array[$key][$childKey] = $childValue->getArrayCopy();
                    } else {
                        $array[$key][$childKey] = $childValue;
                    }
                }
            } else {
                $array[$key] = $this->$getMethod();
            }
        }

        return $array;
    }

    private function buildMethodName($key, $mode = 'get')
    {
        return $mode . StaticFilter::execute($key, 'wordunderscoretocamelcase');
    }
}
