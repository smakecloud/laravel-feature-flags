<?php

namespace RyanChandler\LaravelFeatureFlags\Commands;

use Illuminate\Console\Command;

class LaravelFeatureFlagsCommand extends Command
{
    public $signature = 'laravel-feature-flags';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
