<?php

namespace tests;

use fixtures\presentation\requests\Request;
use tlcal\application\processors\Calendar;
use vsc\application\dispatchers\RwDispatcher;
use vsc\application\processors\NotFoundProcessor;
use vsc\application\sitemaps\ClassMap;
use vsc\application\sitemaps\MappingA;
use vsc\infrastructure\vsc;

class mapTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp  () {
        $req = new Request();
        vsc::getEnv()->setHttpRequest($req);
    }

//    protected function tearDown  () {
//        vsc::setInstance(new vsc());
//    }

    public function uriProvider () {
        return [
            'empty uri' => ['/'],
            'empty path with json' => ['/a.json'],
            'empty path with rss' => ['/a.rss'],
            'empty path with txt' => ['/a.txt'],
            'random uri' => [uniqid('/test/')],
            'random path with json' => [uniqid('/') . '.json'],
            'random path with rss' => [uniqid('/') . '.rss'],
            'random path with txt' => [uniqid('/') . '.txt'],
        ];
    }
    /**
     * @param string $uri
     * @throws \Exception
     * @throws \vsc\application\sitemaps\ExceptionSitemap
     * @dataProvider uriProvider
     */
    public function testGetProcessorMap ($uri) {
        vsc::getEnv()->getHttpRequest()->setUri($uri);

        $o = new RwDispatcher();
        $this->assertTrue($o->loadSiteMap('src/res/map.php'));

        $map = $o->getCurrentProcessorMap();

        $this->assertInstanceOf(MappingA::class, $map);
        $this->assertInstanceOf(ClassMap::class, $map);
        $this->assertEquals(Calendar::class, $map->getPath());
    }
}
