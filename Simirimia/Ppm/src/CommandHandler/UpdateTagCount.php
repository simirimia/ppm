<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 08.02.15
 * Time: 17:57
 */

namespace Simirimia\Ppm\CommandHandler;

use Simirimia\Ppm\Command\UpdateTagCount as UpdateTagCountCommand;
use Simirimia\Ppm\DatabaseCommand\Tag as TagDatabaseCommands;
use Simirimia\Ppm\Dispatchable;
use Simirimia\Ppm\Result\ArrayResult;

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

        return new ArrayResult([
            'status' => 'success'
        ]);
    }
} 