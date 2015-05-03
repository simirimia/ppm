<?php
/**
 * This file is part of PPM by simirimia
 *
 * Date: 01.03.15
 * Time: 22:41
 */
namespace Simirimia\Ppm;

use Simirimia\Core\Config as CoreConfig;
use Simirimia\Core\DatabaseConfig;

interface PpmConfig extends CoreConfig, DatabaseConfig
{
    public function getThumbnailPath();

    public function getSourcePicturePath();

    public function getLogFilePath();

}