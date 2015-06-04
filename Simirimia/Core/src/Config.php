<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 01.03.15
 * Time: 22:36
 */

namespace Simirimia\Core;

interface Config
{
    public function isSetupMode();

    public function getRepositoryType();
}