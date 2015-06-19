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


use Simirimia\Core\Result\CompoundResult;

class DispatchableChain implements Dispatchable
{

    /**
     * @var array
     */
    private $dispatchables = [];

    /**
     * @param Dispatchable $dispatchable
     * @param null|int $offset
     */
    public function add( Dispatchable $dispatchable, $offset = null )
    {
        if ( null === $offset ) {
            $this->dispatchables[] = $dispatchable;
        } else {
            $this->dispatchables[$offset] = $dispatchable;
        }
    }

    /**
     * @return CompoundResult
     */
    public function process()
    {
        $result = new CompoundResult();
        /** @var Dispatchable $dispatchable */
        foreach( $this->dispatchables as $dispatchable ) {
            $result->add( $dispatchable->process() );
        }
        return $result;
    }

}
