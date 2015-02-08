<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 08.02.15
 * Time: 18:16
 */

namespace Simirimia\Ppm;


use Simirimia\Ppm\Result\CompoundResult;

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
