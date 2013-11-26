<?php

namespace Sf2films\FilmsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Sf2films\FilmsBundle\Repository\ContentRepository;

class DefaultControllerTest extends WebTestCase
{
//================================================================
    public function transliterData()
    {
        return array(
            array(array('притет мир')),
            array(array('123')),
            array(array('hello world'))
        );
    }

//================================================================
    /**
     * @dataProvider transliterData
     */
    public function testTransliter($data) {
        $transliter = $this->getMockBuilder('Sf2films\FilmsBundle\Transliter')
//            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock()
        ;

        $result = $transliter->getTranslit($data[0]);
        $this->assertTrue($result != '');
    }

}
