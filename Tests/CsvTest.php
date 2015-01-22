<?php

namespace Zebba\Component\Loader\Tests;

use Zebba\Component\Loader\Csv;

class CsvTest extends \PHPUnit_Framework_TestCase
{
	public function testDump()
	{
		$input = array(
			array(
				'key1' => 'value 1',
				'key2' => 2.,
			), array(
				'key1' => 'value2',
				'key2' => 3,
			)
		);
	
		$output = "key1;key2\r\n\"value 1\";2.00\r\nvalue2;3";
	
		$this->assertEquals($output, Csv::dump($input));
	}
	
	public function testParseFile()
	{
		$input = new \SplFileInfo(__DIR__ . DIRECTORY_SEPARATOR . 'Fixtures/test.csv');
		
		$output = array(array('key1' => 1, 'key2' => 2,));
		
		$this->assertEquals($output, Csv::parse($input));
	}
	
	/**
	 * @expectedException \Zebba\Component\Loader\Exception\ParseException
	 */
	public function testParseBinary()
	{
		$input = new \SplFileInfo(__DIR__ . DIRECTORY_SEPARATOR . 'Fixtures/no_csv.bin');
	
		Csv::parse($input);
	}
	
	/**
	 * @expectedException \Zebba\Component\Loader\Exception\ParseException
	 */
	public function testParseNotReadable()
	{
		$input = new \SplFileInfo(__DIR__ . DIRECTORY_SEPARATOR . 'Fixtures/no_access.bin');
		
		Csv::parse($input);
	}

	public function testParseGermanChars_Iso_8859_1()
	{
		$input = new \SplFileInfo(__DIR__ . DIRECTORY_SEPARATOR . 'Fixtures/characters.iso-8859-1.csv');

		$output = array(
			array('key1' => 'ä', 'key2' => 'Ä'),
			array('key1' => 'ö', 'key2' => 'Ö'),
			array('key1' => 'ü', 'key2' => 'Ü'),
			array('key1' => 'ß', 'key2' => ''),
		);

		$this->assertEquals($output, Csv::parse($input, array('encoding_source' => 'ISO-8859-1')));
	}
}

namespace Zebba\Component\Loader;

function is_readable($filename) {
	if (strpos($filename, 'no_access') !== false) {
		return false;
	}

	return true;
}