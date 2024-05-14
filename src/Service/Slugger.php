<?php

namespace App\Service;

use Symfony\Component\String\Slugger\SluggerInterface;

class Slugger
{
    private $slugger;
    private $toLower;
    
    public function __construct(SluggerInterface $slugger, bool $toLower){
        $this->slugger = $slugger;
        $this->toLower = $toLower;
    }

    /**
     * will sluggify a string and return it
     * @param string $string The string to sluggify
     * @return string the sluggified string
     */
    public function sluggify(string $string):string
    {
        return $this->toLower ? $this->slugger->slug($string)->lower() : $this->slugger->slug($string);
    }
}