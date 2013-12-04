<?php

namespace Sf2films\FilmsBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class SitemapEvent extends Event{

    private $pages = array();

    public function addPage($path, $date_update)
    {
        $this->pages[] = array(
            'path' => $path,
            'date_update' => $date_update
        );
    }

    public function getPages()
    {
        return $this->pages;
    }
}