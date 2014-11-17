<?php

/*
 * Mendo Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mendo\Logger\Provider\Pimple;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Mendo\Logger\Logger;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class LoggerServiceProvider implements ServiceProviderInterface
{
    private $reference;

    public function __construct($reference = 'logger')
    {
        $this->reference = $reference;
    }

    public function register(Container $container)
    {
        $container[$this->reference.'.writers'] = [];

        $container[$this->reference] = function ($c) {
            $logger = new Logger();

            foreach ($c[$this->reference.'.writers'] as $parameters) {
                $writer = $c[$parameters['service']];
                $level = $parameters['level'];
                $logger->addWriter($level, $writer);
            }

            return $logger;
        };
    }
}
