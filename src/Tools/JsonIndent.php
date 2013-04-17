<?php

namespace Rhoban\Blocks\Tools;

/**
 * Clean and indent some json code for better render
 */
class JsonIndent
{
    public static function indent($json)
    {
        // Add line breaks
        $json = str_replace("}", "\n}", $json);
        $json = str_replace(",", ",\n", $json);
        $json = str_replace("{\"", "{\n\"", $json);
        $json = str_replace("[\"", "[\n\"", $json);
        $json = str_replace(":[", ":[\n", $json);

        // Indent
        $lines = explode("\n", $json);
        $depth = 0;
        $json = '';
        foreach ($lines as $line) {
            $depth -= substr_count($line, '}');
            for ($i=0; $i<$depth; $i++) {
                $json .= '    ';
            }
            $json .= $line."\n";
            $depth += substr_count($line, '{');
        }

        return $json;
    }
}
