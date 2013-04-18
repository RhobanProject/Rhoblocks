<?php

namespace Rhoban\Blocks\Tools;

/**
 * Clean and indent some cCode code for better render
 */
class CIndent
{
    public static function indent($cCode)
    {
        $lines = explode("\n", $cCode);
        $cCode = '';
        foreach ($lines as $line) {
            $cCode .= trim($line)."\n";
        }

        // Indent
        $lines = explode("\n", $cCode);
        $depth = 0;
        $cCode = '';
        foreach ($lines as $line) {
            $oldDepth = $depth;
            $depth -= substr_count($line, '}');
            for ($i=0; $i<$depth; $i++) {
                $cCode .= '    ';
            }
            $cCode .= $line."\n";
            if ($depth == 0 && $oldDepth) {
                $cCode .= "\n";
            }
            $depth += substr_count($line, '{');
        }

        return $cCode;
    }
}
