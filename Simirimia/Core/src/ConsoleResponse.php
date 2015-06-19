<?php
/*
 * This file is part of the simirimia/core package.
 *
 * (c) https://github.com/simirimia
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Simirimia\Core;


class ConsoleResponse extends Response
{
    /**
     * Output data
     */
    public function send()
    {
        echo $this->getBody();
    }

}