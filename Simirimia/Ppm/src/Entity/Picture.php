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
     * @var array
     */
    private $exifComplete = [];

    /**
     * @var array
     */
    private $tags = [];

    /**
     * @var array
     */
    private $exif = [];

    /**
     * @var Picture
     */
    private $isAlternativeTo = null;

    /**
     * @var bool
     */
    private $hasAlternatives = false;

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

    /**
     * @param array $exifComplete
     */
    public function setExifComplete($exifComplete)
    {
        $this->exifComplete = $exifComplete;
    }

    /**
     * @return array
     */
    public function getExifComplete()
    {
        return $this->exifComplete;
    }

    /**
     * @param array $exif
     */
    public function setExif($exif)
    {
        $this->exif = $exif;
    }

    /**
     * @return array
     */
    public function getExif()
    {
        return $this->exif;
    }

    /**
     * @param $tag
     */
    public function addTag( $tag )
    {
        $this->tags[] = (string)$tag;
    }

    public function removeTag( $tag ) {
        $this->tags = array_diff( $this->tags, [ $tag ] );
    }

    /**
     * @param array $tags
     */
    public function addTags( array $tags )
    {
        $this->tags = array_merge( $this->tags, $tags );
    }

    /**
     * @param array $tags
     */
    public function setTags( array $tags )
    {
        $this->tags = $tags;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    // Exif access shortcuts

    public function getExifOrientation()
    {
        return isset($this->exif['Orientation']) ? $this->exif['Orientation'] : null;
    }

    /**
     * @param Picture $mainPicture
     */
    public function setIsAlternativeTo( Picture $mainPicture )
    {
        $this->isAlternativeTo = $mainPicture;
        $mainPicture->setHasAlternatives( true );
    }

    /**
     * @return Picture
     */
    public function getIsAlternativeTo()
    {
        return $this->isAlternativeTo;
    }

    /**
     * @param boolean $hasAlternatives
     */
    public function setHasAlternatives($hasAlternatives)
    {
        $this->hasAlternatives = $hasAlternatives;
    }

    /**
     * @return boolean
     */
    public function getHasAlternatives()
    {
        return $this->hasAlternatives;
    }




} 