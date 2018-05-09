<?php

use PHPUnit\Framework\TestCase;
use Simplon\Device\Device;

class DeviceTest extends TestCase
{
    /**
     * @param string $agent
     * @param string $type
     * @param string $model
     *
     * @dataProvider deviceProvider
     * @throws Exception
     */
    public function testDevice(string $agent, string $type, string $model)
    {
        $dd = new Device($agent);
        $this->assertEquals($type, $dd->getType());
        $this->assertEquals($model, $dd->getModel());
    }

    /**
     * @param string $agent
     * @param bool   $isBot
     *
     * @dataProvider botProvider
     * @throws Exception
     */
    public function testBots(string $agent, bool $isBot)
    {
        $dd = new Device($agent);
        $this->assertEquals($isBot, $dd->isBot());
    }

    /**
     * @throws Exception
     */
    public function testEmpty()
    {
        $dd = new Device();
        $this->assertEquals(Device::TYPE_FALLBACK, $dd->getType());
        $this->assertEquals(Device::MODEL_FALLBACK, $dd->getModel());
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

            ['Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', Device::TYPE_MOBILE, Device::MODEL_IOS],
            ['Mozilla/5.0 (Linux; Android 5.1.1; Nexus 6 Build/LYZ28E) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.95 Mobile Safari/537.36', Device::TYPE_MOBILE, Device::MODEL_ANDROID],
            ['Mozilla/5.0 (Linux; Android 5.0; SM-G900P Build/LRX21T) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.95 Mobile Safari/537.36', Device::TYPE_MOBILE, Device::MODEL_ANDROID],

            #
            # TABLET
            #

            ['Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', Device::TYPE_TABLET, Device::MODEL_IOS],
            ['Mozilla/5.0 (iPad; CPU OS 9_3_2 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13F69 Safari/601.1', Device::TYPE_TABLET, Device::MODEL_IOS],
            ['Mozilla/5.0 (Linux; Android 4.4.2; en-us; SAMSUNG SM-T230NU Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Version/1.5 Chrome/28.0.1500.94 Safari/537.36', Device::TYPE_TABLET, Device::MODEL_ANDROID],
            ['Mozilla/5.0 (Linux; U; Android 4.2.2; en-us; GT-P5113 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30', Device::TYPE_TABLET, Device::MODEL_ANDROID],

            #
            # FALLBACK
            #
            ['Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.95 Safari/537.36', Device::TYPE_FALLBACK, Device::MODEL_FALLBACK],
            ['Mozilla/5.0 (CrKey armv7l 1.5.16041) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.0 Safari/537.36', Device::TYPE_FALLBACK, Device::MODEL_FALLBACK],
        ];
    }

    /**
     * @return array
     */
    public function botProvider()
    {
        return [
            ['Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', true],
            ['Mozilla/5.0 (compatible; Bingbot/2.0; +http://www.bing.com/bingbot.htm)', true],
            ['Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)', true],
            ['facebot', true],
            ['ia_archiver (+http://www.alexa.com/site/help/webmasters; crawler@alexa.com)', true],
        ];
    }
}