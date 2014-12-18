<?php

namespace Zebba\Component\Loader;

use Zebba\Component\Loader\Exception\ParseException;

class Csv implements LoaderInterface
{
    /**
     * @param $input
     * @param array $options
     * @return array
     */
    public static function parse($input, array $options = array())
    {
        $default_options = array(
            'delimiter' => ';',
            'encoding_source' => 'UTF-8',
            'encoding_target' => 'UTF-8',
        );

        $options = array_merge($default_options, $options);

        // if input is a file, process it
        $file = '';

        if (false === strpos($input, '\n') && is_file($input)) {
            if (false === is_readable($input)) {
                throw new ParseException(sprintf('Unable to parse "%s" as the file is not readable.', $input));
            }

            $file = $input;
            $input = file_get_contents($file);
        }

        $csv = new Csv\Parser();

        try {
            return $csv->parse($input, $options['delimiter'], $options);
        } catch (ParseException $e) {
            if ($file) { $e->setParsedFile($file); }

            throw $e;
        }
    }

    /**
     * @param $array
     * @param array $options
     * @return string
     */
    public static function dump($array, array $options = array())
    {
        $default_options = array(
            'delimiter' => ';',
            'encoding_source' => 'UTF-8',
            'encoding_target' => 'UTF-8',
        );

        $options = array_merge($default_options, $options);

        $csv = new Csv\Dumper();

        return $csv->dump($array, $options['delimiter'], $options);
    }
}