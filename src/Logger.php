<?php

/*
 * Gobline
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gobline\Logger;

use Psr\Log\LoggerInterface;
use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class Logger extends AbstractLogger
{
    private $writers;

    public function __construct()
    {
        $this->writers = [
            LogLevel::EMERGENCY => [],
            LogLevel::ALERT => [],
            LogLevel::CRITICAL => [],
            LogLevel::ERROR => [],
            LogLevel::WARNING => [],
            LogLevel::NOTICE => [],
            LogLevel::INFO => [],
            LogLevel::DEBUG => [],
        ];
    }

    /**
     * @param string          $level
     * @param LoggerInterface $strategy
     *
     * @throws \InvalidArgumentException
     */
    public function addWriter($level, LoggerInterface $strategy)
    {
        switch ($level) {
            default:
                throw new \InvalidArgumentException('Invalid $level');
            case LogLevel::DEBUG:
                $this->writers[LogLevel::DEBUG][] = $strategy;
            case LogLevel::INFO:
                $this->writers[LogLevel::INFO][] = $strategy;
            case LogLevel::NOTICE:
                $this->writers[LogLevel::NOTICE][] = $strategy;
            case LogLevel::WARNING:
                $this->writers[LogLevel::WARNING][] = $strategy;
            case LogLevel::ERROR:
                $this->writers[LogLevel::ERROR][] = $strategy;
            case LogLevel::CRITICAL:
                $this->writers[LogLevel::CRITICAL][] = $strategy;
            case LogLevel::ALERT:
                $this->writers[LogLevel::ALERT][] = $strategy;
            case LogLevel::EMERGENCY:
                $this->writers[LogLevel::EMERGENCY][] = $strategy;
        }
    }

    /**
     * @param string $level
     * @param string $message
     * @param array  $context
     */
    public function log($level, $message, array $context = [])
    {
        foreach ($this->writers[$level] as $writer) {
            $writer->log($level, $message, $context);
        }
    }
}
