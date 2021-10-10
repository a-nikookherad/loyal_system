<?php


namespace App\Logics\Script;


class ScriptRunner
{
    private $services;

    public function __construct(Run $scripts)
    {
        $this->services = $scripts;
    }

    public function run()
    {
//        foreach ($this->services as $service) {
        $this->services->run();
//        }
//        dd("done");
    }
}
