<?php
// Define the widget's body template. Will be encoded as a JSON string when stored in the database.
$widget_body = array(
	'key_1' => '__KEY_1__',
	'key_2' => '__KEY_2__',
	'key_3' => '__KEY_3__',
	'key_4' => '__KEY_4__'
);

// Global widget configuration.
$widget_config = array(
	'name' 		=> '__NAME__',
	'author' 	=> '__AUTHOR__',
	'desc' 		=> '__DESCRIPTION',
	'body' 		=> $widget_body,
	'license' 	=> '__LICENSE__',
	'version' 	=> '__VERSION__'
);

// Define the types of each body key value pair. Might not be needed at all since PHP can reconize the type using the is_* functions (is_int(), is_string(), etc)
$widget_body_types = array(
	'key_1' =>  'bool',
	'key_2' => 'string',
	'key_3' => 'int',
	'key_4' => 'array(value1,value2,value3)'
);
?>