<?php

namespace Simplon\Device;

use Jaybizzle\CrawlerDetect\CrawlerDetect;

class Device implements DeviceInterface
{
    const TYPE_DESKTOP = 'desktop';
    const TYPE_TABLET = 'tablet';
    const TYPE_MOBILE = 'mobile';
    const TYPE_CRAWLER = 'crawler';

    /**
     * @var string|null
     */
    protected $agent;
    /**
     * @var string
     */
    private $envData;
    /**
     * @var string
     */
    private $type;

    /**
     * @param string|null $agent
     *
     * @throws \Exception
     */
    public function __construct(string $agent = null)
    {
        $this->agent = $agent;
        $this->envData = getenv('DEVICE');
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        if (!$this->type)
        {
            $this->type = $this->envData ? $this->envData : $this->getTypeByMobileDetect();
        }

        return $this->type;
    }

    /**
     * @return bool
     */
    public function isCrawler(): bool
    {
        return $this->getType() === self::TYPE_CRAWLER;
    }

    /**
     * @return bool
     */
    public function isTablet(): bool
    {
        return $this->getType() === self::TYPE_TABLET;
    }

    /**
     * @return bool
     */
    public function isMobile(): bool
    {
        return $this->getType() === self::TYPE_MOBILE;
    }

    /**
     * @return bool
     */
    public function isDesktop(): bool
    {
        return $this->getType() === self::TYPE_DESKTOP;
    }

    /**
     * @return string
     */
    private function getTypeByMobileDetect(): string
    {
        $mobileDetect = new \Mobile_Detect(null, $this->agent);
        $crawlerDetect = new CrawlerDetect(null, $this->agent);

        $type = self::TYPE_DESKTOP;

        if ($crawlerDetect->isCrawler())
        {
            $type = self::TYPE_CRAWLER;
        }
        elseif ($mobileDetect->isTablet())
        {
            $type = self::TYPE_TABLET;
        }
        elseif ($mobileDetect->isMobile())
        {
            $type = self::TYPE_MOBILE;
        }

        return $type;
    }
}