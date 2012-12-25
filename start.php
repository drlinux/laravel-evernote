<?php

// Autoloader::map(array(
//     'Thrift'          => Bundle::path('evernote').'src/Thrift.php',
//     'TTransport'      => Bundle::path('evernote').'src/transport/TTransport.php',
//     'THttpClient'     => Bundle::path('evernote').'src/transport/THttpClient.php',
//     'TProtocol'       => Bundle::path('evernote').'src/protocol/TProtocol.php',
//     'TBinaryProtocol' => Bundle::path('evernote').'src/protocol/TBinaryProtocol.php',
//     'Types_types'     => Bundle::path('evernote').'src/packages/Types/Types_types.php',
//     'UserStore'       => Bundle::path('evernote').'src/packages/UserStore/UserStore.php',
//     'NoteStore'       => Bundle::path('evernote').'src/packages/NoteStore/NoteStore.php'
// ));

require_once(Bundle::path('evernote').'src'.DS.'Thrift.php');
require_once(Bundle::path('evernote').'src'.DS.'transport/TTransport.php');
require_once(Bundle::path('evernote').'src'.DS.'transport/THttpClient.php');
require_once(Bundle::path('evernote').'src'.DS.'protocol/TProtocol.php');
require_once(Bundle::path('evernote').'src'.DS.'protocol/TBinaryProtocol.php');
require_once(Bundle::path('evernote').'src'.DS.'packages/Types/Types_types.php');
require_once(Bundle::path('evernote').'src'.DS.'packages/UserStore/UserStore.php');
require_once(Bundle::path('evernote').'src'.DS.'packages/NoteStore/NoteStore.php');

Autoloader::directories(array(
	Bundle::path('evernote').'libraries',
	Bundle::path('evernote').'models'
));

if (!class_exists('OAuth')) {
	die("<span style=\"color:red\">The PHP OAuth Extension is not installed</span>");
}