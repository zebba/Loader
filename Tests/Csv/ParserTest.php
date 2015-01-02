<?php

namespace Zebba\Component\Loader\Tests\Csv;

use Zebba\Component\Loader\Csv;

/**
 * @author Sebastian Kuhlmann <zebba@hotmail.de>
 */
class ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParse()
    {
        $input = "key1;key2\nvalue1;2\nvalue2;3";

        $output = array(
            array(
                'key1' => 'value1',
                'key2' => 2,
            ), array(
                'key1' => 'value2',
                'key2' => 3,
            )
        );

        $parser = new Csv\Parser();

        $this->assertEquals($output, $parser->parse($input));
    }
    
    /**
     * @expectedException \Zebba\Component\Loader\Exception\ParseException
     */
    public function testParseUnevenLines()
    {
    	$input = "key1;key2\nvalue1;2;NO\nvalue2;3";
    
    	$parser = new Csv\Parser();
   		$parser->parse($input);
    }
} 