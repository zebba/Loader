<?php

namespace Zebba\Component\Loader\Csv;

use Zebba\Component\Loader\Exception\ParseException;

/**
 * @author Sebastian Kuhlmann <zebba@hotmail.de>
 */
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

        try {
        	$input = iconv($options['encoding_source'], $options['encoding_target'], $input);
        } catch (\Exception $e) {
        	throw new ParseException('The file might not be a CSV file after all.');
        }

        $lines = preg_split ('/$\R?^/m', $input);
        $lines = array_map('trim', $lines);

        $header = trim($lines[0]);
        unset($lines[0]);

        $keys = explode($delimiter, $header);

        $result = array();

        foreach ($lines as $line) {
            $values = str_getcsv($line, $delimiter);
            
            try {
                if (is_array($keys) && is_array($values) && count($keys) !== count($values)) {
                    throw new \DomainException();
                }

                $result[] = array_combine($keys, $values);
            } catch (\DomainException $e) {
                throw new ParseException('The CSV-file is damaged.');
            }
        }

        return $result;
    }
} 