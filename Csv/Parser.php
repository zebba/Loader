<?php

namespace Zebba\Component\Loader\Csv;

use Zebba\Component\Loader\Exception\ParseException;

class Parser
{
    /**
     * @param string $input
     * @param string $delimiter
     * @param array $options
     * @throws ParseException
     * @return array
     */
    public function parse($input, $delimiter = ';', array $options = array())
    {
        $default_options = array(
            'encoding_source' => 'UTF-8',
            'encoding_target' => 'UTF-8',
        );

        $options = array_merge($default_options, $options);

        $input = iconv($options['encoding_source'], $options['encoding_target'], $input);

        $lines = preg_split ('/$\R?^/m', $input);
        $lines = array_map('trim', $lines);

        $header = trim($lines[0]);
        unset($lines[0]);

        $keys = explode($delimiter, $header);

        $result = array();

        foreach ($lines as $line) {
            $values = str_getcsv($line, $delimiter);

            try {
                if (count($keys) !== count($values)) {
                    throw new ParseException(sprintf('The CSV-file is damaged. With %d columns defined in the header %d in the data-row are wrong: %s', count($keys), count($values), $line));
                }

                $result[] = array_combine($keys, $values);
            } catch (ParseException $e) {
                if (0 == strlen($line)) { continue; }

                throw $e;
            }
        }

        return $result;
    }
} 