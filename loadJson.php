<?php

require __DIR__ . '/bootstrap.php';

use Service\PdoWordStorage;

// $container = new Container($config);
// $wordLoader = $container->getWordLoader();
$words = new PdoWordStorage($config);
$words = $words->fetchAllWords();

echo json_encode($words, JSON_UNESCAPED_UNICODE);

?>
