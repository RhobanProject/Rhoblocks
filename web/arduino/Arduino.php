<?php

/**
 * Handles an Arduino device
 */
class Arduino
{
    // Path to arduino 1.5
    protected $path;

    // Arduino port
    protected $port;

    // Arduino board
    protected $board;

    public function __construct(array $config)
    {
        if (!isset($config['arduino']) || !isset($config['port']) || !isset($config['board'])) {
            throw new \RuntimeException('Bad configuration for arduino');
        }

        $this->path = $config['arduino'];
        $this->port = $config['port'];
        $this->board = $config['board'];
    }

    /**
     * Compile some code and send it to the remote board
     */
    public function compileAndSend($code)
    {
        
        $name = 'sketch_'.substr(sha1(mt_rand().'/'.time()),0,8);
        $dir = '/tmp/'.$name;
        mkdir($dir);
        $file = $dir.'/'.$name.'.pde';
        file_put_contents($file, $code);

        $command = "DISPLAY=\":0\" $this->path/arduino --board $this->board --port $this->port --upload $file 2>&1";
        $result = shell_exec($command);

        unlink($file);
        rmdir($dir);

        return $result;
    }
}
