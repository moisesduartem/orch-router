<?php


namespace App\Classes;

/**
 * Class Test
 * @package App\Classes
 */
class Test
{
    protected String $word;

    public function __construct(String $word)
    {
        $this->word = $word;
        $this->hello();
    }

    public function hello(): void
    {
        echo 'Hello ' . $this->word;
    }
}