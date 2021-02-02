<?php

namespace Sostheblack\InstagramApi\Commands;

use Illuminate\Console\Command;

class InstagramApiCommand extends Command
{
    public $signature = 'instagram-api';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
