<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 11.10.14
 * Time: 20:36
 */

namespace Simirimia\Ppm\QueryHandler;

use Simirimia\Core\Dispatchable;
use Simirimia\Core\Result\ArrayResult;
use Simirimia\Core\Result\Result;
use Simirimia\Ppm\Query\Tags as TagsCommand;
use Simirimia\Ppm\Repository\Tag as TagRepository;
use Simirimia\Ppm\Entity\Tag;

class Tags implements Dispatchable
{
    /**
     * @var \Simirimia\Ppm\Query\AllThumbnails
     */
    private $command;

    /**
     * @var \Simirimia\Ppm\Repository\Tag
     */
    private $repository;

    public function __construct( TagsCommand $command, TagRepository $repository )
    {
        $this->command = $command;
        $this->repository = $repository;
    }

    public function process()
    {
        $data = [];
        $collection = $this->repository->findAll();

        /** @var Tag $tag */
        foreach( $collection as $tag ) {
            $data[$tag->getId()] = [
                'tag' => $tag->getTitle(),
                'count' => $tag->getCount()
            ];
        }

        $result = new ArrayResult( $data );
        $result->setResultCode( Result::OK );
        return $result;
    }
} 