<?php
/**
 * This file is part of PPM by simirimia
 *
 * Date: 01.03.15
 * Time: 22:41
 */
namespace Simirimia\Ppm;

use Simirimia\Core\Config;
use Simirimia\Core\DatabaseConfig;

interface PpmConfig extends Config, DatabaseConfig
{
    public function getThumbnailPath();

    public function getSourcePicturePath();

    public function getLogFilePath();

}