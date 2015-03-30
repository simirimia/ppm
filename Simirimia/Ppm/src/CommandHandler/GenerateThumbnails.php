<?php
/**
 * This file is part of PPM by simirimia
 *
 * Date: 11.10.14
 * Time: 17:23
 */

namespace Simirimia\Ppm\CommandHandler;

use Intervention\Image\Constraint;
use Intervention\Image\ImageManager;
use Monolog\Logger;
use Simirimia\Core\Dispatchable;
use Simirimia\Core\Result\ArrayResult;
use Simirimia\Core\Result\Result;
use Simirimia\Ppm\Command\GenerateThumbnails as GenerateThumbnailsCommand;
use Simirimia\Ppm\Entity\Picture;
use Simirimia\Ppm\Repository\Picture as PictureRepository;

class GenerateThumbnails implements Dispatchable
{

    private $batchSize = 3;

    /**
     * @var PictureRepository
     */
    private $repository;

    /**
     * @var GenerateThumbnailsCommand
     */
    private $command;

    /**
     * @var \Monolog\Logger
     */
    private $logger;

    public function __construct( GenerateThumbnailsCommand $command, PictureRepository $repository, Logger $logger )
    {
        $this->command = $command;
        $this->repository = $repository;
        $this->logger = $logger;
    }

    public function process()
    {
        $pictures = $this->repository->findWithoutThumbnails( $this->batchSize + 1 );
        $i = 0;
        $fail = [ ];
        $ok = [ ];
        $skipped = [ ];
        /** @var Picture $picture */
        foreach ( $pictures as $picture ) {
            $i++;
            try {
                if ( $picture->getThumbSmall() != '' ) {
                    $skipped[] = [
                        'id' => $picture->getId(),
                        'message' => 'Thumbnails already exist'
                    ];
                }

                if ( !is_readable( $picture->getPath() ) ) {
                    $fail[] = [
                        'id' => $picture->getId(),
                        'errorType' => 'FileSystemError',
                        'message' => 'Picture source file is not readable'
                    ];
                    continue;
                }

                $this->generateThumbnails( $picture );
                $ok[] = [
                    'id' => $picture->getId()
                ];
            } catch ( \Exception $e ) {
                $fail[] = [
                    'id' => $picture->getId(),
                    'errorType' => get_class( $e ),
                    'message' => $e->getMessage()
                ];
            }
            if ( $i > $this->batchSize ) {
                return $this->getResult( $ok, $skipped, $fail, true );
            }
        }

        return $this->getResult( $ok, $skipped, $fail, false );
    }

    private function generateThumbnails( Picture $picture )
    {
        $thumbnailSizes = [
            'small' => 300,
            'medium' => 800,
            'large' => 1400
        ];

        $imageManager = new ImageManager();


        $this->logger->addDebug(
            "ID: " . $picture->getId() . " Rotation: " .
            $picture->getExifOrientationObject()->getDegreesToRotate() . "\n"
        );


        foreach ( $thumbnailSizes as $name => $size ) {
            $image = $imageManager->make( $picture->getPath() );
            $image->resize(
                $size,
                $size,
                function ( Constraint $constraint ) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                }
            );

            switch ( $picture->getExifOrientationObject()->getDegreesToRotate() ) {
                case 0:
                    break;
                case 1:
                    break;
                case 6:
                    $image->rotate( 270 );
                    break;
                case 8:
                    break;
                default:
                    $this->logger->addError(
                        'Invalid Orientation: ' .
                        $picture->getExifOrientationObject()->getDegreesToRotate()
                        . ' for picture ID: ' . $picture->getId() . ' with name: ' . $picture->getPath()
                    );

                    return;

            }

            $filename = $picture->getId() . '_' . (string)$size . '.jpg';

            $path = $this->command->getThumbnailPath() . '/' . $filename;

            $image->save( $path );

            switch ( $name ) {
                case 'small':
                    $picture->setThumbSmall( $filename );
                    break;
                case 'medium':
                    $picture->setThumbMedium( $filename );
                    break;
                case 'large':
                    $picture->setThumbLarge( $filename );
                    break;
            }
        }

        $this->repository->save( $picture );
    }

    private function getResult( array $ok, array $skipped, array $failed, $moreAvailable )
    {
        $result = new ArrayResult(
            [
                'ok' => $ok,
                'skipped' => $skipped,
                'failed' => $failed,
                'moreAvailable' => $moreAvailable
            ]
        );

        if ( empty($failed) ) {
            $result->setResultCode( Result::OK );
        } elseif( empty($ok) ) {
            $result->setResultCode( Result::BACKEND_ERROR );
        } else {
            $result->setResultCode( Result::BACKEND_ERROR );
        }

        return $result;
    }
} 