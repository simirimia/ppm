<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 14.02.15
 * Time: 10:41
 */

namespace Simirimia\Ppm\QueryHandler;


use Simirimia\Ppm\Dispatchable;
use Simirimia\Ppm\Query\OrientationInfo as OrientationInfoQuery;
use Simirimia\Ppm\Repository\Picture as PictureRepository;
use Simirimia\Ppm\Entity\Picture;
use Simirimia\Ppm\Result\ArrayResult;

class OrientationInfo implements Dispatchable
{
    /**
     * @var \Simirimia\Ppm\Query\OrientationInfo
     */
    private $query;

    /**
     * @var \Simirimia\Ppm\Repository\Picture
     */
    private $repository;

    public function __construct( OrientationInfoQuery $query, PictureRepository $repository )
    {
        $this->query = $query;
        $this->repository = $repository;
    }

    public function process()
    {
        $picture = $this->repository->findById( $this->query->getId() );

        $orientation = $picture->getExifOrientationObject();

        return new ArrayResult( [
            'orientation' => $orientation->getOrientation(),
            'make' => $orientation->getMake(),
            'model' => $orientation->getModel(),
            'degreesToRotate' => $orientation->getDegreeesToRotate()
        ] );
    }


} 