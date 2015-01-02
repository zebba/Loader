<?php

namespace Zebba\Component\Loader;

/**
 * @author Sebastian Kuhlmann <zebba@hotmail.de>
 */
interface LoaderInterface
{
	/**
	 * 
	 * @param mixed:string|\SplFileInfo $input
	 * @param array $options
	 */
    public static function parse($input, array $options = array());

    /**
     * 
     * @param array $array
     * @param array $options
     */
    public static function dump(array $array, array $options = array());
} 