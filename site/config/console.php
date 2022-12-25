<?php

$conf = require __DIR__.'/common.php';

return array_merge_recursive($conf, [
    'controllerNamespace' => 'app\commands',
]);