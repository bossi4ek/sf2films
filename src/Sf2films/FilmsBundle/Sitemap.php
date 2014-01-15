<?php

namespace Sf2films\FilmsBundle;

use Sf2films\FilmsBundle\Event\SitemapEvent;
use Sf2films\FilmsBundle\Repository\ContentRepository;

class Sitemap {

    private $repo;

    function __construct(ContentRepository $repo)
    {
        $this->repo = $repo;
    }

    public function onSitemapEvent(SitemapEvent $event) {

        // Get all films
        $films = $this->repo->findAllFilmsForSitemap();

        foreach ($films as $film) {
            $path = sprintf('films/%s', $film->getSlug());
            $event->addPage($path, $film->getUpdated());
        }
    }
}