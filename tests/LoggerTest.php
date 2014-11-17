<?php

/*
 * Mendo Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Mendo\Logger\Logger;
use Psr\Log\AbstractLogger;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class LoggerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->logger = new Logger();
        $this->logger->addWriter('info', new DummyLogWriter());
    }

    public function testLogLevelSame()
    {
        $this->expectOutputString('hello world');
        $this->logger->info('hello world');
    }

    public function testLogLevelBelow()
    {
        $this->expectOutputString('');
        $this->logger->debug('hello world');
    }

    public function testLogLevelAbove()
    {
        $this->expectOutputString('hello world');
        $this->logger->warning('hello world');
    }
}

class DummyLogWriter extends AbstractLogger
{
    public function log($level, $message, array $context = [])
    {
        echo $message;
    }
}
