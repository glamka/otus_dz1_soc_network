<?php


use Phinx\Seed\AbstractSeed;

class ExampleUp extends AbstractSeed
{
    public $dir = __DIR__;
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $sql = file_get_contents($this->dir.'/../data/Example_up.sql', true);
        $this->execute($sql);
    }
}
