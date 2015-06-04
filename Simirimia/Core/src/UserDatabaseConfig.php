<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 08.03.15
 * Time: 09:47
 */

namespace Simirimia\Core;

interface UserDatabaseConfig
{
    public function getUserDatabaseUser();

    public function getUserDatabasePassword();

    public function getUserDatabaseDsn();
}