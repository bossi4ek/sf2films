<?php

namespace Sf2films\FilmsBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ContentRepository extends EntityRepository
{

    public function findAllFilms()
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT content
                FROM Sf2filmsFilmsBundle:Content content
                ORDER BY content.date_create DESC');

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    public function findOneByTranslit($translit)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT content
                FROM Sf2filmsFilmsBundle:Content content
                WHERE content.name_translit = :translit'
            )->setParameter('translit', $translit);

        try {
            return $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    public function findAllByGenre($translit)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT content
                FROM Sf2filmsFilmsBundle:Content content
                LEFT JOIN content.genres genre
                WHERE genre.name_translit = :translit
                ORDER BY content.date_create DESC'
            )->setParameter('translit', $translit);

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    public function findAllByPerson($translit)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT content
                FROM Sf2filmsFilmsBundle:Content content
                LEFT JOIN content.persons person
                WHERE person.name_translit = :translit
                ORDER BY content.date_create DESC'
            )->setParameter('translit', $translit);

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}
