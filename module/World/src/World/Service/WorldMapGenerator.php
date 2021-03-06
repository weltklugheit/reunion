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

/**
 * Description of WorldMapGenerator
 *
 * @author heiner
 */
class WorldMapGenerator
{

    protected $minX;
    protected $maxX;
    protected $minY;
    protected $maxY;
    protected $imageWidth;
    protected $imageHeight;
    protected $showScale;
    protected $maxIterations;

    public function __construct(array $limits, array $size, $maximumIterations = 200, $showScale = false)
    {
        list($this->minX, $this->maxX, $this->minY, $this->maxY) = $limits;
        list($this->imageWidth, $this->imageHeight) = $size;

        $this->maxIterations = $maximumIterations;
    }

    public function __destruct()
    {
        imagedestroy($this->_image);
        unset($this->_image);
        unset($this->_colours);
    }

    public function setUpImage()
    {
        $this->_image = imagecreate($this->imageWidth, $this->imageHeight);

        // Load the palette to find colours
        $this->_colours = new Palette($this->maxIterations, $this->_image);
    }

    protected function generateWorldMap()
    {

    }
}
