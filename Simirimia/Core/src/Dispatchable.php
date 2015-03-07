<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 08.02.15
 * Time: 18:07
 */

namespace Simirimia\Core;

use Simirimia\Core\Result\Result;

interface Dispatchable
{
    /**
     * @return Result
     */
    public function process();
} 