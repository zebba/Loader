Loader
=======

Installation
------------
   
Modify your composer.json:

```json
{
    "require" : {
        "zebba/loader" : "1.*"
    }
}    
```

Usage
-----

### Parsing CSV files

``` php
<?php

$csv = "key1;key2\r\nvalue1;2\r\nvalue2;3";

// $csv = new \SplFileInfo(...);

try {
	$output = Csv::parse($csv);
} catch (\Zebba\Component\Loader\Exception\ParseException $e) {
	throw $e;
}	

/*
 * $output = array(
 * 	array(
 *		'key1' => 'value1',
 *      'key2' => 2,
 *	), array(
 *   	key1' => 'value2',
 *      'key2' => 3,
 *	)
 * );
*/

```

### Dumping arrays to CSV files


``` php
<?php

<?php

$input = array(
	array(
    	'key1' => 'value1',
        'key2' => 2,
	), array(
    	'key1' => 'value2',
        'key2' => 3,
	)
);

$csv = Csv::dump($input);

// $csv = "key1;key2\r\nvalue1;2\r\nvalue2;3";

```
