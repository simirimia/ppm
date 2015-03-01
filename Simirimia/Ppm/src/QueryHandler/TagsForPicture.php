<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 08.02.15
 * Time: 19:11
 */

namespace Simirimia\Ppm\QueryHandler;


use Simirimia\Core\Dispatchable;
use Simirimia\Ppm\Query\TagsForPicture as TagsForPictureQuery;
use Simirimia\Ppm\Repository\Picture as PictureRepository;
use Simirimia\Ppm\Entity\Picture as PictureEntity;
use Simirimia\Core\Result\ArrayResult;

class TagsForPicture implements Dispatchable
{
    /**
     * @var \Simirimia\Ppm\Query\TagsForPicture
     */
    private $query;

    /**
     * @var \Simirimia\Ppm\Repository\Picture
     */
    private $repository;

    /**
     * @param TagsForPictureQuery $query
     * @param PictureRepository $repository
     */
    public function __construct( TagsForPictureQuery $query, PictureRepository $repository )
    {
        $this->query = $query;
        $this->repository = $repository;
    }

    public function process()
    {
        /** @var PictureEntity $picture */
        $picture = $this->repository->findById( $this->query->getPictureId() );
        return new ArrayResult( [
            'tags' => $picture->getTags()
        ] );
    }
} 