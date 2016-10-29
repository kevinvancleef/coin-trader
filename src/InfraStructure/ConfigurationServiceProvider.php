<?php
declare(strict_types = 1);

namespace Coin\Trader\InfraStructure;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Noodlehaus\Config;

/**
 * Class ConfigurationServiceProvider
 * @package Coin\Trader\InfraStructure
 */
class ConfigurationServiceProvider extends AbstractServiceProvider
{
    /** @var string[] */
    protected $provides = [
        Config::class
    ];

    /**
     * @return void
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->add(Config::class, Config::class)
            ->withArgument(__DIR__ . '/../../etc/app.configuration.php');
    }
}
