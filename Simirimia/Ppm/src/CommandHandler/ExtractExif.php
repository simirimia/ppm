<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 05.10.14
 * Time: 13:55
 */

namespace Simirimia\Ppm\CommandHandler;

use Intervention\Image\ImageManager;

use Simirimia\Ppm\Command\ExtractExif as ExctractExifCommand;
use Simirimia\Ppm\Repository\Picture as PictureRepository;
use Simirimia\Ppm\Entity\Picture;

class ExtractExif {

    /**
     * @var \Simirimia\Ppm\Command\ExtractExif
     */
    private $command;

    /**
     * @var \Simirimia\Ppm\Repository\Picture
     */
    private $repository;

    public function __construct( ExctractExifCommand $command, PictureRepository $repository )
    {
        $this->command = $command;
        $this->repository = $repository;
    }

    public function process()
    {
        $pictures = $this->repository->findAll();
        foreach ( $pictures as $picture ) {
            $this->extract( $picture );
        }
    }

    private function extract( Picture $picture )
    {
        $imageManager = new ImageManager();
        $image = $imageManager->make( $picture->getPath() );
        $exifComplete = $image->exif();

        if ( !is_array($exifComplete) ) {
            // no exif data found
            return;
        }

        //var_dump( $exifComplete );

        $useTags = [ 'FileName', 'FileDateTime', 'FileSize', 'MimeType', 'Make', 'Model', 'Orientation', 'XResolution',
            'YResolution', 'ResolutionUnit', 'DateTime', 'ExposureTime', 'FNumber', 'ExposureProgram', 'ISOSpeedRating',
            'DateTimeOriginal', 'DateTimeDigitized', 'ShutterSpeedValue', 'ApertureValue', 'ExposureBiasValue',
            'MeteringMode', 'Flash', 'FocalLength', 'FlashPixVersion', 'ColorSpace', 'ExifImageWidth', 'ExifImageLength',
            'InteroperabilityOffset', 'FocalPlaneXResolution', 'FocalPlaneYResolution', 'FocalPlaneResolutionUnit',
            'CustomRendered', 'ExposureMode', 'WhiteBalance', 'ScreenCaptureType', 'InterOperabilityIndex',
            'vInterOperabilityVersion' ];

        // COMPUTED THUMBNAIL

        $exif = [];
        foreach( $exifComplete as $key => $value ) {
            if ( in_array( $key, $useTags ) ) {
                $exif[$key] = $value;
            }
        }

        //var_dump( $exif );

        $picture->setExif( $exif );
        $picture->setExifComplete( $exif );
        $this->repository->save( $picture );
    }

}