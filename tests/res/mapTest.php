<?php

namespace tests;

use fixtures\presentation\requests\Request;
use tlcal\application\controllers\ICalController;
use tlcal\application\processors\Calendar;
use tlcal\application\processors\CalendarDay;
use tlcal\application\processors\CalendarMonth;
use vsc\application\dispatchers\RwDispatcher;
use vsc\application\sitemaps\ClassMap;
use vsc\application\sitemaps\MappingA;
use vsc\infrastructure\vsc;

class mapTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RwDispatcher
     */
    protected $dispatcher;

    protected function setUp  () {
        vsc::getEnv()->setHttpRequest(new Request());
        $this->dispatcher = new RwDispatcher();
    }

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

    public function uriProviderForYYYYMMDDUrl () {
        return [
            '30thEleventh' => ['/2015/11/30/'],
            '30thNovember' => ['/2015/november/30/'],
        ];
    }

    public function uriProviderForYYYYMMUrl () {
        return [
            'theTwelfth' => ['/2015/12/'],
            'December' => ['/2015/december/'],
        ];
    }

    /**
     * @param string $uri
     * @dataProvider uriProviderForYYYYMMUrl
     */
    public function testGetMonthProcessorMap ($uri) {
        vsc::getEnv()->getHttpRequest()->setUri($uri);

        $this->assertTrue($this->dispatcher->loadSiteMap('src/res/map.php'));
        $map = $this->dispatcher->getCurrentProcessorMap();

        $this->assertInstanceOf(MappingA::class, $map);
        $this->assertInstanceOf(ClassMap::class, $map);
        $this->assertEquals(CalendarMonth::class, $map->getPath());
    }

    /**
     * @param string $uri
     * @dataProvider uriProviderForYYYYMMDDUrl
     */
    public function testGetDayProcessorMap ($uri) {
        vsc::getEnv()->getHttpRequest()->setUri($uri);

        $this->assertTrue($this->dispatcher->loadSiteMap('src/res/map.php'));
        $map = $this->dispatcher->getCurrentProcessorMap();

        $this->assertInstanceOf(MappingA::class, $map);
        $this->assertInstanceOf(ClassMap::class, $map);
        $this->assertEquals(CalendarDay::class, $map->getPath());
    }

    /**
     * @param string $uri
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
