<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 11.10.14
 * Time: 20:49
 */

namespace Simirimia\Ppm;

use \InvalidArgumentException;
use \Exception;

class Config implements PpmConfigUser
{
    private $isSetupMode;
    private $user_db_dsn;
    private $user_db_user;
    private $user_db_password;
    private $picture_db_dsn;
    private $picture_db_user;
    private $picture_db_password;
    private $thumbnail_path;
    private $log_path;
    private $picture_source_path;
    private $repository_type;

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
            throw new Exception( 'global config file not readable' );
        }

        if ( !file_exists( $folderPath . '/config_local.ini.php' ) || !is_readable( $folderPath . '/config_local.ini.php' ) ) {
            throw new Exception( 'local config file not readable' );
        }


        $config = parse_ini_file( $folderPath . '/config_global.ini.php' );
        $config = array_merge( $config, parse_ini_file( $folderPath . '/config_local.ini.php' ) );
        $config['isSetupMode'] = file_exists( $folderPath . '/setup_in_progress___remove_me' );

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

    public function getRepositoryType()
    {
        return $this->repository_type;
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

    public function getUserDatabaseUser()
    {
        return $this->user_db_user;
    }

    public function getUserDatabasePassword()
    {
        return $this->user_db_password;
    }

    public function getUserDatabaseDsn()
    {
        return $this->user_db_dsn;
    }

    public function getPictureDatabaseUser()
    {
        return $this->picture_db_user;
    }

    public function getPictureDatabasePassword()
    {
        return $this->picture_db_password;
    }

    public function getPictureDatabaseDsn()
    {
        return $this->picture_db_dsn;
    }

    public function isSetupMode()
    {
        return $this->isSetupMode;
    }


} 