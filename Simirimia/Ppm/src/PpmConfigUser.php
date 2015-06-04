<?php
/**
 * This file is part of PPM by simirimia
 *
 * Date: 01.03.15
 * Time: 22:41
 */
namespace Simirimia\Ppm;

use Simirimia\Core\Config as CoreConfig;
use Simirimia\Core\UserDatabaseConfig;
use Simirimia\Ppm\PictureDatabaseConfig;

interface PpmConfigUser extends CoreConfig, UserDatabaseConfig, PictureDatabaseConfig
{
    public function getThumbnailPath();

    public function getSourcePicturePath();

    public function getLogFilePath();

}