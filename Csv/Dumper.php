<?php

namespace Zebba\Component\Loader\Csv;

class Dumper
{
    /**
     * @param array $array
     * @param string $delimiter
     * @param array $options
     * @return string
     */
    public function dump(array $array, $delimiter = ';', array $options = array())
    {
        $default_options = array(
            'enclosure' => '"',
            'encoding_source' => 'UTF-8',
            'encoding_target' => 'UTF-8',
            'extract_keys' => false,
        );

        $options = array_merge($default_options, $options);

        $result = null;

        if ($options['extract_keys']) {
            $keys = array_keys($array[0]);
            $result .= implode($delimiter, $keys);
        }

        foreach ($array as $line) {
            foreach ($line as $key => $field) {
                if (substr_count($field, ' ') || substr_count($field, $delimiter)) {
                    $line[$key] = $options['enclosure'] . $field . $options['enclosure'];
                } elseif (is_float($field) && ! is_integer($field)) {
                    $line[$key] = number_format($field, 2, ',', '');
                }
            }

            $result .= implode($delimiter, $line) . "\r\n";
        }

        $result = iconv($options['encoding_source'], $options['encoding_target'], $result);

        return $result;
    }
} 