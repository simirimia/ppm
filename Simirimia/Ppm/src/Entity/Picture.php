<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 18.09.14
 * Time: 23:06
 */

namespace Simirimia\Ppm\Entity;


class Picture {

    /**
     * @var string
     */
    private $path;

    /**
     * @var bool
     */
    private $isProcessed;

    /**
     * @param boolean $isProcessed
     */
    public function setIsProcessed($isProcessed)
    {
        $this->isProcessed = (bool)$isProcessed;
    }

    /**
     * @return boolean
     */
    public function getIsProcessed()
    {
        return $this->isProcessed;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = (string)$path;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }



} 