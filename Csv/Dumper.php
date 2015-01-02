<?php

namespace Zebba\Component\Loader\Csv;

/**
 * @author Sebastian Kuhlmann <zebba@hotmail.de>
 */
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
            'header' => true,
        	'number_format_decimals' => 2,
        	'number_format_dec_point' => '.',
        	'number_format_thousands_sep' => '',
        );

        $options = array_merge($default_options, $options);

        $result = null;

        if ($options['header']) {
            $keys = array_keys($array[0]);
            $result .= implode($delimiter, $keys) . "\r\n";
        }

        $counter = 0;
        
        foreach ($array as $line) {
            foreach ($line as $key => $field) {
                if (substr_count($field, ' ') || substr_count($field, $delimiter)) {
                    $line[$key] = $options['enclosure'] . $field . $options['enclosure'];
                } elseif (is_float($field) && ! is_integer($field)) {
                    $line[$key] = number_format($field,
                    	$options['number_format_decimals'],
                    	$options['number_format_dec_point'],
                    	$options['number_format_thousands_sep']
                    );
                }
            }

            $result .= implode($delimiter, $line);
            
            $counter++;
            
            if ($counter < count($array)) { $result .= "\r\n"; }
        }
        
        $result = iconv($options['encoding_source'], $options['encoding_target'], $result);
        
        return $result;
    }
} 