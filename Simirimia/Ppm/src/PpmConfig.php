<?php
/**
 * This file is part of PPM by simirimia
 *
 * Date: 01.03.15
 * Time: 22:41
 */
namespace Simirimia\Ppm;

use Simirimia\Core\Config;

interface PpmConfig extends Config
{
    public function getThumbnailPath();

    public function getSourcePicturePath();

    public function getLogFilePath();

    public function getDatabaseUser();

    public function getDatabasePassword();

    public function getDatabaseDsn();
}