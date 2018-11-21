<?php

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Simplon\Device\Device;

class DeviceTest extends TestCase
{
    /**
     * @param string $agent
     * @param string $type
     *
     * @dataProvider deviceProvider
     * @throws Exception
     */
    public function testDevice(string $agent, string $type)
    {
        $dd = new Device($agent);
        Assert::assertEquals($type, $dd->getType(), 'Given agent: ' . $agent);
    }

    /**
     * @param string $agent
     * @param bool   $isCrawler
     *
     * @dataProvider crawlerProvider
     * @throws Exception
     */
    public function testCrawlers(string $agent, bool $isCrawler)
    {
        $dd = new Device($agent);
        Assert::assertEquals($isCrawler, $dd->isCrawler());
    }

    /**
     * @throws Exception
     */
    public function testDesktop()
    {
        $dd = new Device();
        Assert::assertEquals(Device::TYPE_DESKTOP, $dd->getType());
    }

    /**
     * @return array
     */
    public function deviceProvider()
    {
        return [
            #
            # MOBILE
            #

            ['Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', Device::TYPE_MOBILE],
            ['Mozilla/5.0 (Linux; Android 5.1.1; Nexus 6 Build/LYZ28E) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.95 Mobile Safari/537.36', Device::TYPE_MOBILE],
            ['Mozilla/5.0 (Linux; Android 5.0; SM-G900P Build/LRX21T) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.95 Mobile Safari/537.36', Device::TYPE_MOBILE],
            ['Mozilla/5.0 (Linux; Android 7.0; SM-G892A Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/60.0.3112.107 Mobile Safari/537.36', Device::TYPE_MOBILE],
            ['Mozilla/5.0 (iPhone; CPU iPhone OS 12_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/12.0 Mobile/15E148 Safari/604.1', Device::TYPE_MOBILE],

            #
            # TABLET
            #

            ['Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', Device::TYPE_TABLET],
            ['Mozilla/5.0 (iPad; CPU OS 9_3_2 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13F69 Safari/601.1', Device::TYPE_TABLET],
            ['Mozilla/5.0 (Linux; Android 4.4.2; en-us; SAMSUNG SM-T230NU Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Version/1.5 Chrome/28.0.1500.94 Safari/537.36', Device::TYPE_TABLET],
            ['Mozilla/5.0 (Linux; U; Android 4.2.2; en-us; GT-P5113 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30', Device::TYPE_TABLET],
            ['Mozilla/5.0 (Linux; Android 7.0; Pixel C Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/52.0.2743.98 Safari/537.36', Device::TYPE_TABLET],
            ['Mozilla/5.0 (Linux; Android 7.0; SM-T827R4 Build/NRD90M) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.116 Safari/537.36', Device::TYPE_TABLET],
            ['Mozilla/5.0 (Linux; Android 5.0.2; SAMSUNG SM-T550 Build/LRX22G) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/3.3 Chrome/38.0.2125.102 Safari/537.36', Device::TYPE_TABLET],
            ['Mozilla/5.0 (Linux; Android 6.0.1; SM-T800 Build/MMB29K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.107 Safari/537.36', Device::TYPE_TABLET],

            #
            # DESKTOP
            #
            ['Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.95 Safari/537.36', Device::TYPE_DESKTOP],
            ['Mozilla/5.0 (CrKey armv7l 1.5.16041) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.0 Safari/537.36', Device::TYPE_DESKTOP],
        ];
    }

    /**
     * @return array
     */
    public function crawlerProvider()
    {
        return [
            ['Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', true],
            ['Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', true],
            ['Mozilla/5.0 (compatible; Bingbot/2.0; +http://www.bing.com/bingbot.htm)', true],
            ['Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)', true],
            ['facebot', true],
            ['ia_archiver (+http://www.alexa.com/site/help/webmasters; crawler@alexa.com)', true],
        ];
    }
}