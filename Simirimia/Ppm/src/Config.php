<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 11.10.14
 * Time: 20:49
 */

namespace Simirimia\Ppm;

use \InvalidArguementException;

class Config implements PpmConfig
{
    private $db_dsn;
    private $db_user;
    private $db_password;
    private $thumbnail_path;
    private $log_path;
    private $picture_source_path;

    /**
     * @param $folderPath
     * @return Config
     * @throws InvalidArgumentException
     * @throws \Exception
     */
    public static function fromIniFilesInFolder( $folderPath )
    {
        if ( !is_string($folderPath) ) {
            throw new InvalidArgumentException( 'Param $folderPath needs to be a string' );
        }

        if ( !file_exists( $folderPath . '/config_global.ini.php' ) || !is_readable( $folderPath . '/config_global.ini.php' ) ) {
            throw new \Exception( 'global config file not readable' );
        }

        if ( !file_exists( $folderPath . '/config_local.ini.php' ) || !is_readable( $folderPath . '/config_local.ini.php' ) ) {
            throw new \Exception( 'local config file not readable' );
        }

        $config = parse_ini_file( $folderPath . '/config_global.ini.php' );
        $config = array_merge( $config, parse_ini_file( $folderPath . '/config_local.ini.php' ) );

        return new Config( $config );
    }

    public function __construct( array $config )
    {
        foreach( $config as $entry => $value ) {
            if ( property_exists( $this, $entry )  ) {
                $this->{$entry} = (string)$value;
            }
        }
    }

    public function getThumbnailPath()
    {
        return $this->thumbnail_path;
    }

    public function getSourcePicturePath()
    {
        return $this->picture_source_path;
    }

    public function getLogFilePath()
    {
        return $this->log_path;
    }

    public function getDatabaseUser()
    {
        return $this->db_user;
    }

    public function getDatabasePassword()
    {
        return $this->db_password;
    }

    public function getDatabaseDsn()
    {
        return $this->db_dsn;
    }
} 