<?php

$arguments = isset($argv[2]) ? $argv[2] : '[]';
$arguments = json_decode($arguments, true);
shell_exec('mkdir ~/.ssh');
if (isset($arguments['workspace'])) {
    chdir($arguments['workspace']['path']);
    $key = $arguments['workspace']['keys']['private'];
    shell_exec('echo "' . $key . '" > ~/.ssh/id_rsa');
}
shell_exec('chmod -R 600 ~/.ssh');

$vargs = $arguments['vargs'];
$commands = isset($vargs['commands']) ? $vargs['commands'] : [];
foreach ($commands as $command) {
    echo shell_exec($command);
}
