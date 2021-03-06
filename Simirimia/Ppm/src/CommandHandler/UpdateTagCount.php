<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 08.02.15
 * Time: 17:57
 */

namespace Simirimia\Ppm\CommandHandler;

use Simirimia\Core\Result\Result;
use Simirimia\Ppm\Command\UpdateTagCount as UpdateTagCountCommand;
use Simirimia\Ppm\DatabaseCommand\Tag as TagDatabaseCommands;
use Simirimia\Core\Dispatchable;
use Simirimia\Core\Result\ArrayResult;

class UpdateTagCount implements Dispatchable
{
    /**
     * @var \Simirimia\Ppm\Command\UpdateTagCount
     */
    private $command;

    /**
     * @var \Simirimia\Ppm\DatabaseCommand\Tag
     */
    private $database;

    public function __construct( UpdateTagCountCommand $command, TagDatabaseCommands $database )
    {
        $this->command = $command;
        $this->database = $database;
    }

    public function process()
    {
        $this->database->updateTagCountFor(  $this->command->getTag());

        $result = new ArrayResult([
            'status' => 'success'
        ]);
        $result->setResultCode( Result::OK );
        return $result;
    }
} 