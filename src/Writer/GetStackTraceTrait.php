<?php

/*
 * Gobline
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gobline\Logger\Writer;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
trait GetStackTraceTrait
{
    /**
     * @param Exception $e
     * @param bool      $html
     *
     * @return string
     */
    private function getExceptionStackTrace(\Exception $e, $html = true)
    {
        $wrap = ($html) ? ['<b>', '</b>'] : ['', ''];
        $bold = function ($s) use ($wrap) { return implode($s, $wrap); };

        $newLine = ($html) ? '<br>' : "\n";

        $trace = $bold("Error Time :").date('Y-m-d H:i:s A');
        $trace .= $newLine.$bold("Error Code :").$e->getCode();
        $trace .= $newLine.$bold("Error Message :").$e->getMessage();
        $trace .= $newLine.$bold("Error File :").$e->getFile();
        $trace .= $newLine.$bold("Error File Line :").$e->getLine();
        $trace .= $newLine.$bold("Error Trace :").$newLine;

        $trace .= ($html) ? preg_replace("/\n/", '<br>', $e->getTraceAsString()) : $e->getTraceAsString();

        return $trace;
    }
}
