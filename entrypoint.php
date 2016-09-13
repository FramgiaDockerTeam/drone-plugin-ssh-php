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
    $exit = execute($command);
    if ($exit) {
        exit(1);
    }
}

function execute($cmd) {
    $proc = proc_open($cmd, [['pipe','r'],['pipe','w'],['pipe','w']], $pipes);
    while(($line = fgets($pipes[1])) !== false) {
        fwrite(STDOUT,$line);
    }
    while(($line = fgets($pipes[2])) !== false) {
        fwrite(STDERR,$line);
    }
    fclose($pipes[0]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    return proc_close($proc);
}
