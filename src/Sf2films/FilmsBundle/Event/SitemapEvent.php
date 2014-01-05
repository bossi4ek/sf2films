<?php

namespace Sf2films\FilmsBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class SitemapEvent extends Event{

    private $pages = array();

    public function addPage($path, $updated)
    {
        $this->pages[] = array(
            'path' => $path,
            'updated' => $updated
        );
    }

    public function getPages()
    {
        return $this->pages;
    }
}