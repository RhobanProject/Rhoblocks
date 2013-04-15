<?php

namespace Rhoban\Blocks;

class ArchiveWriter
{
    // Directory for output
    protected $outDirectory;

    // Directory containing temporary files
    protected $tmpDirectory;

    // The user token
    protected $userToken = null;

    // Session key for the user token
    protected $sessionKey;

    public function __construct($outDirectory, $tmpDirectory = '/tmp/archiveWriter/', $sessionKey = 'archiveWriterToken')
    {
        $this->outDirectory = $outDirectory;
        $this->tmpDirectory = $tmpDirectory;
        $this->sessionKey = $sessionKey;
        $this->createToken();

        if (!is_dir($tmpDirectory)) {
            @mkdir($tmpDirectory, 0777, true);
        }
    }

    protected function randomName()
    {
        return substr(sha1(time().':'.mt_rand()), 0, 10);
    }

    protected function createToken()
    {
        if ($this->userToken == null) {
            if (isset($_SESSION[$this->sessionKey])) {
                $this->userToken = $_SESSION[$this->sessionKey];
            } else {
                $this->userToken = $this->randomName();
                $_SESSION[$this->sessionKey] = $this->userToken;
            }
        }

    }

    public function getToken()
    {
        return $this->userToken;
    }

    public function writeFiles(array $files = array())
    {
        $names = '';
        $tmp = $this->tmpDirectory . '/' . $this->randomName();
        mkdir($tmp);

        foreach ($files as $name => $contents) {
            file_put_contents($tmp . '/' . $name, $contents);
            $names .= ' ' . $name;
        }

        $output = $this->outDirectory . '/' . $this->userToken . '.tgz';
        shell_exec("tar zcvf $output -C $tmp $names");

        foreach ($files as $name => $contents) {
            @unlink($tmp . '/' . $name);
        }
        @rmdir($tmp);

        return $output;
    }
}
