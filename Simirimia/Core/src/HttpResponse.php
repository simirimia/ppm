<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 08.03.15
 * Time: 18:40
 */

namespace Simirimia\Core;


class HttpResponse extends Response
{
    public function send()
    {
        http_response_code( $this->getResultCode() );
        echo $this->getBody();
    }
}
