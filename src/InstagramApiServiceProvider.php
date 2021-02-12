<?php

namespace Sostheblack\InstagramApi;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Sostheblack\InstagramApi\Commands\InstagramApiCommand;

/**
 * Class InstagramApiServiceProvider
 *
 * @package Sostheblack\InstagramApi
 */
class InstagramApiServiceProvider extends PackageServiceProvider
{
    /**
     * @param  Package  $package
     */
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('instagram-api')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_instagram_api_table')
            ->hasCommand(InstagramApiCommand::class);

        config()->set('filesystems.disks.instagram-api', [
            'driver' => 'local',
            'root' => __DIR__ . '/../storage/auth',
        ]);
    }
}
