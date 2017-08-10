<?php

namespace Xdm\Ipnet\Commands;

use Illuminate\Console\Command;
use Xdm\Ipnet\IpxDataUpdate;

class UpdateCommand extends Command
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'ipnet:update';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Update Ipnet source file';

    /**
     * Execute the command.
     *
     * @return void
     */
    public function fire()
    {
        $ipx_update = IpxDataUpdate::getInstance();
        $ipx_update->make();
        $this->info('Update ipnet successfully');
    }
}
