<?php

namespace tests;

use fixtures\presentation\requests\Request;
use tlcal\application\controllers\ICalController;
use tlcal\application\processors\Calendar;
use vsc\application\dispatchers\DispatcherA;
use vsc\application\dispatchers\RwDispatcher;
use vsc\application\sitemaps\ClassMap;
use vsc\application\sitemaps\MappingA;
use vsc\infrastructure\vsc;

class mapTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DispatcherA
     */
    protected $dispatcher;

    protected function setUp  () {
        $req = new Request();
        vsc::getEnv()->setHttpRequest($req);
        $this->dispatcher = new RwDispatcher();
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

        $this->assertTrue($this->dispatcher->loadSiteMap('src/res/map.php'));
        $map = $this->dispatcher->getCurrentProcessorMap();

        $this->assertInstanceOf(MappingA::class, $map);
        $this->assertInstanceOf(ClassMap::class, $map);
        $this->assertEquals(Calendar::class, $map->getPath());
    }
    /**
     * @param string $uri
     * @throws \Exception
     * @throws \vsc\application\sitemaps\ExceptionSitemap
     * @dataProvider uriProvider
     */
    public function testGetControllerMap ($uri) {
        vsc::getEnv()->getHttpRequest()->setUri($uri);

        $this->assertTrue($this->dispatcher->loadSiteMap('src/res/map.php'));
        $map = $this->dispatcher->getCurrentControllerMap();

        $this->assertInstanceOf(MappingA::class, $map);
        $this->assertInstanceOf(ClassMap::class, $map);
        $this->assertEquals(ICalController::class, $map->getPath());
    }
}
