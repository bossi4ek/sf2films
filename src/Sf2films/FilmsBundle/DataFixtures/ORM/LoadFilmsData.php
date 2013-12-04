<?php

namespace Sf2films\FilmsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Sf2films\FilmsBundle\Entity\Content;
use Sf2films\FilmsBundle\Entity\Genre;
use Sf2films\FilmsBundle\Entity\Person;
use Sf2films\FilmsBundle\Transliter;

class LoadFilmsData implements FixtureInterface, OrderedFixtureInterface
{
    public function getOrder()
    {
        return 10;
    }

    public function copyImg()
    {
        $source = __DIR__.'/img';
        $destination = __DIR__.'/../../../../../web/uploads/poster';

        for ($i = 1; $i <= 4; $i++) {
            copy($source."/".$i.".jpg", $destination."/".$i.".jpg");
        }
        copy($source."/not_img.jpg", $destination."/not_img.jpg");
    }

    public function load(ObjectManager $manager)
    {
        $this->copyImg();

        $translit = new Transliter();

        $genre_name = 'Боевик';
        $genre1 = new Genre();
        $genre1->setName($genre_name);
        $genre1->setNameTranslit($translit->getTranslit($genre_name));
        $genre1->setIsPublish(1);
        $manager->persist($genre1);

        $genre_name = 'Комедия';
        $genre2 = new Genre();
        $genre2->setName($genre_name);
        $genre2->setNameTranslit($translit->getTranslit($genre_name));
        $genre2->setIsPublish(1);
        $manager->persist($genre2);

        $genre_name = 'Ужасы';
        $genre3 = new Genre();
        $genre3->setName($genre_name);
        $genre3->setNameTranslit($translit->getTranslit($genre_name));
        $genre3->setIsPublish(1);
        $manager->persist($genre3);

        $genre_name = 'Спорт';
        $genre4 = new Genre();
        $genre4->setName($genre_name);
        $genre4->setNameTranslit($translit->getTranslit($genre_name));
        $genre4->setIsPublish(0);
        $manager->persist($genre4);

        $manager->flush();

//====================================================================
        $person_name = 'Сильвестр Сталлоне';
        $person1 = new Person();
        $person1->setName($person_name);
        $person1->setNameTranslit($translit->getTranslit($person_name));
        $person1->setDateBirth(111);
        $person1->setIsPublish(1);
        $person1->setGenderCode(1);
        $manager->persist($person1);

        $person_name = 'Арнольд Шварценеггер';
        $person2 = new Person();
        $person2->setName($person_name);
        $person2->setNameTranslit($translit->getTranslit($person_name));
        $person2->setDateBirth(111);
        $person2->setIsPublish(1);
        $person2->setGenderCode(1);
        $manager->persist($person2);

        $person_name = 'Жан-Клод Ван Дамм';
        $person3 = new Person();
        $person3->setName($person_name);
        $person3->setNameTranslit($translit->getTranslit($person_name));
        $person3->setDateBirth(111);
        $person3->setIsPublish(1);
        $person3->setGenderCode(1);
        $manager->persist($person3);

        $person_name = 'Роберт Джон Берк';
        $person4 = new Person();
        $person4->setName($person_name);
        $person4->setNameTranslit($translit->getTranslit($person_name));
        $person4->setDateBirth(111);
        $person4->setIsPublish(0);
        $person4->setGenderCode(1);
        $manager->persist($person4);

//====================================================================
        $films_name = 'Капитан Филлипс';
        $films_description = 'В начале апреля 2009 года, близ берегов Африки, несколько сомалийских пиратов атакуют и пытаются захватить массивный контейнеровоз MV Maersk Alabama. Команда корабля активно сопротивляется и в конце концов не даёт взять себя в плен. Захватчики вынуждены ретироваться и покинуть судно на небольшом катере, прихватив с собой немолодого капитана Ричарда Филлипса...';
        $films1 = new Content();
        $films1->setName($films_name);
        $films1->setNameTranslit($translit->getTranslit($films_name));
        $films1->setPosterImg("1.jpg");
        $films1->setDescription($films_description);
        $films1->setDateCreate(time());
        $films1->setDateUpdate(time() + 1);
        $films1->addGenre($genre1);
        $films1->addGenre($genre2);
        $films1->addPerson($person1);
        $films1->addPerson($person2);
        $films1->setYear(2013);
        $films1->setDuration(134);
        $films1->setBudget(55000000);
        $films1->setIsPublish(1);
        $manager->persist($films1);
//====================================================================

        $films_name = 'Два ствола';
        $films_description = 'Это история двух грабителей, которые на самом деле не те, кем кажутся. Один из них — агент из управления по борьбе с наркотиками, а другой — тайный агент разведки ВМС. Сами того не желая, они занимаются расследованием дел друг друга, а также воруют деньги у мафии. Через некоторое время героям придется украсть 50 миллионов долларов у ЦРУ.';
        $films2 = new Content();
        $films2->setName($films_name);
        $films2->setNameTranslit($translit->getTranslit($films_name));
        $films2->setPosterImg("2.jpg");
        $films2->setDescription($films_description);
        $films2->setDateCreate(time());
        $films2->setDateUpdate(time() + 1);
        $films2->addGenre($genre1);
        $films2->addGenre($genre2);
        $films2->addGenre($genre3);
        $films2->addPerson($person1);
        $films2->addPerson($person3);
        $films2->setYear(2013);
        $films2->setDuration(109);
        $films2->setBudget(61000000);
        $films2->setIsPublish(1);
        $manager->persist($films2);

//====================================================================
        $films_name = 'Росомаха Бессмертный';
        $films_description = 'Новая глава приключений Росомахи развернётся в Японии, где Логану предстоит выяснить, что острее - когти Росомахи или меч Серебряного Самурая.';
        $films3 = new Content();
        $films3->setName($films_name);
        $films3->setNameTranslit($translit->getTranslit($films_name));
        $films3->setPosterImg("3.jpg");
        $films3->setDescription($films_description);
        $films3->setDateCreate(time());
        $films3->setDateUpdate(time() + 1);
        $films3->addGenre($genre2);
        $films3->addPerson($person1);
        $films3->setYear(2013);
        $films3->setDuration(126);
        $films3->setBudget(120000000);
        $films3->setIsPublish(1);
        $manager->persist($films3);

//====================================================================
        $films_name = 'Армагеддец';
        $films_description = 'Их подвиг был бы увековечен в книге рекордов Гиннеса, если бы они знали, что Гиннесс – это не только пиво. Пятеро друзей ставят себе высокую цель - организовать грандиозный забег по барам. Опасности подстерегают их на каждом шагу: красотка, от которой сходила с ума вся школа, так и тянет налево, в то время как справа надвигается таинственная угроза. В результате алкомарафон плавно переходит в реальный Армагеддец...';
        $films4 = new Content();
        $films4->setName($films_name);
        $films4->setNameTranslit($translit->getTranslit($films_name));
        $films4->setPosterImg("4.jpg");
        $films4->setDescription($films_description);
        $films4->setDateCreate(time());
        $films4->setDateUpdate(time() + 1);
        $films4->addGenre($genre1);
        $films4->addGenre($genre2);
        $films4->addGenre($genre3);
        $films4->addPerson($person1);
        $films4->addPerson($person2);
        $films4->addPerson($person3);
        $films4->setYear(2013);
        $films4->setDuration(109);
        $films4->setBudget(20000000);
        $films4->setIsPublish(0);
        $manager->persist($films4);

        $manager->flush();
    }
}