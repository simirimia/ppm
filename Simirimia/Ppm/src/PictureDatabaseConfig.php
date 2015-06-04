<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 08.03.15
 * Time: 09:47
 */

namespace Simirimia\Ppm;

interface PictureDatabaseConfig
{
    public function getPictureDatabaseUser();

    public function getPictureDatabasePassword();

    public function getPictureDatabaseDsn();
}