<?php

/**
 * Class Installer
 * This class is responsible for installing the framework.
 */
class Installer
{
    /**
     * Install framework.
     */
    public function install(){

        // download the template
        if (!file_exists(ABSPATH . '/src')){

            // if not, download it from https://github.com/teamtimer/pakk
            $zip = file_get_contents('https://github.com/teamtimer/pakk/zipball/master');
            file_put_contents(ABSPATH . '/wp-content/pakk.zip', $zip);

            //check if we have zip extension
            if (!extension_loaded('zip')) {
                throw new \Exception('Please enable zip extension');
            }

            $zip = new \ZipArchive;

            if ($zip->open(ABSPATH . '/wp-content/pakk.zip') === TRUE) {

                //extract to temp folder
                $zip->extractTo(ABSPATH . '/pakk-src-temp');
                $files = scandir(ABSPATH . '/pakk-src-temp');
                $firstFolder = $files[2];

                //move src folder
                rename(ABSPATH . '/pakk-src-temp/' . $firstFolder. '/src', ABSPATH . '/src');

                //move composer.json if it doesn't exist
                if (!file_exists(ABSPATH . '/composer.json')) {
                    //copy composer json
                    copy(ABSPATH . '/pakk-src-temp/' . $firstFolder. '/composer.json', ABSPATH . '/composer.json');
                }

                //remove temp folder
                $this->rrmdir(ABSPATH . '/pakk-src-temp');
                $zip->close();

                //remove zip
                unlink(ABSPATH . '/wp-content/pakk.zip');

            } else {
                throw new \Exception('Could not extract pakk.zip');
            }
        }

        // download composer
        if (!file_exists(ABSPATH . '/composer.phar') || !file_exists(ABSPATH . '/vendor'))
        {
            // download composer
            file_put_contents(ABSPATH . '/composer.phar', file_get_contents('https://getcomposer.org/composer.phar'));

            // run composer install
            shell_exec('php ' . ABSPATH . '/composer.phar install --no-interaction --working-dir=' . ABSPATH);

            // remove composer.phar
            unlink(ABSPATH . '/composer.phar');
        }

        //redirect to wp-admin
        wp_redirect(admin_url());
    }

    /**
     * Delete hook.
     */
    public function delete(){
        // remove everything under wp-content/plugins/pakk-hook/
        $this->rrmdir(ABSPATH . 'wp-content/plugins/pakk-hook');

        // redirect to wp-admin
        wp_redirect(admin_url());
    }

    /**
     * Recursively remove a directory
     * @param $dir
     */
    public function rrmdir($dir)
    {
        if (is_dir($dir))
        {
            $objects = scandir($dir);

            foreach ($objects as $object)
            {
                if ($object != '.' && $object != '..')
                {
                    if (filetype($dir.'/'.$object) == 'dir') {$this->rrmdir($dir.'/'.$object);}
                    else {unlink($dir.'/'.$object);}
                }
            }

            reset($objects);
            rmdir($dir);
        }
    }
}