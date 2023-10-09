<?php

define('EXTRACT_DIRECTORY', ABSPATH."/extractedComposer");

if (file_exists(EXTRACT_DIRECTORY.'/vendor/autoload.php') == true) {
    echo "Extracted autoload already exists. Skipping phar extraction as presumably it's already extracted.";
}
else{
    $composerPhar = new Phar(ABSPATH.'/composer.phar');
    //php.ini setting phar.readonly must be set to 0
    $composerPhar->extractTo(EXTRACT_DIRECTORY);
}

//This requires the phar to have been extracted successfully.
require_once (EXTRACT_DIRECTORY.'/vendor/autoload.php');

//Use the Composer classes
use Composer\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\StreamOutput;
use Composer\Console\HtmlOutputFormatter;

// change out of the webroot so that the vendors file is not created in
// a place that will be visible to the intahwebz
chdir('../');

//Create a stream to write to
$stream = fopen('php://temp', 'w+');

//Create the commands
$input = new ArrayInput(array('command' => 'update'));
$output = new StreamOutput($stream, StreamOutput::VERBOSITY_VERY_VERBOSE, true, new HtmlOutputFormatter());
$application = new Application();
$application->setAutoExit(false);
$code = $application->run($input, $output);

rewind($stream);
$buffer = stream_get_contents($stream);

echo "<pre>";
echo $buffer;
echo "</pre>";

fclose($stream);

?>
