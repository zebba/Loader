<?php

namespace Zebba\Component\Loader\Tests\Csv;

use Zebba\Component\Loader\Csv;

class DumperTest extends \PHPUnit_Framework_TestCase
{
    public function testDump()
    {
        $input = array(
            array(
                'key1' => 'value1',
                'key2' => 2,
            ), array(
                'key1' => 'value2',
                'key2' => 3,
            )
        );

        $output = 'key1;key2\nvalue1;2\nvalue2;3';

        $dumper = new Csv\Dumper();

        $this->assertEquals($output, $dumper->dump($input));
    }
} 