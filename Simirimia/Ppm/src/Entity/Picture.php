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
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $path = '';

    /**
     * @var string
     */
    private $thumbSmall = '';

    /**
     * @var string
     */
    private $thumbMedium = '';

    /**
     * @var string
     */
    private $thumbLarge = '';

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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

    /**
     * @param string $thumbLarge
     */
    public function setThumbLarge($thumbLarge)
    {
        $this->thumbLarge = $thumbLarge;
    }

    /**
     * @return string
     */
    public function getThumbLarge()
    {
        return $this->thumbLarge;
    }

    /**
     * @param string $thumbMedium
     */
    public function setThumbMedium($thumbMedium)
    {
        $this->thumbMedium = $thumbMedium;
    }

    /**
     * @return string
     */
    public function getThumbMedium()
    {
        return $this->thumbMedium;
    }

    /**
     * @param string $thumbSmall
     */
    public function setThumbSmall($thumbSmall)
    {
        $this->thumbSmall = $thumbSmall;
    }

    /**
     * @return string
     */
    public function getThumbSmall()
    {
        return $this->thumbSmall;
    }




} 