<?php
$turn['turn'] = '';

$file = json_encode($turn);
file_put_contents('./turn.json', $file);
