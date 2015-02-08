<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 08.02.15
 * Time: 17:45
 */

namespace Simirimia\Ppm\DatabaseCommand;

use \R;

class Tag
{

    public function updateTagCountFor( $tag )
    {
        R::exec( 'UPDATE tag t SET counter = (
                      SELECT count(p.id)
                      FROM picture_tag pt
                      JOIN picture p ON p.id = pt.picture_id
                      WHERE pt.tag_id = t.id
                      GROUP BY t.id
                  )
                  WHERE t.title = :title', [ 'title' => $tag ] );
    }

} 