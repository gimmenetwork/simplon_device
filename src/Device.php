<?php

namespace Simplon\Device;

use Jaybizzle\CrawlerDetect\CrawlerDetect;

class Device implements DeviceInterface
{
    const MODEL_FALLBACK = 'FALLBACK';
    const MODEL_IOS = 'IOS';
    const MODEL_ANDROID = 'ANDROID';

    const TYPE_FALLBACK = 'FALLBACK';
    const TYPE_TABLET = 'TABLET';
    const TYPE_MOBILE = 'MOBILE';

    /**
     * @var \Mobile_Detect
     */
    private $mobileDetect;
    /**
     * @var CrawlerDetect
     */
    private $crawlerDetect;

    /**
     * @param string|null $agent
     *
     * @throws \Exception
     */
    public function __construct(string $agent = null)
    {
        $this->mobileDetect = new \Mobile_Detect(null, $agent);
        $this->crawlerDetect = new CrawlerDetect(null, $agent);
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        $model = self::MODEL_FALLBACK;

        if ($this->mobileDetect->isIOS())
        {
            $model = self::MODEL_IOS;
        }

        elseif ($this->mobileDetect->isAndroidOs())
        {
            $model = self::MODEL_ANDROID;
        }

        return $model;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        $type = self::TYPE_FALLBACK;

        if ($this->mobileDetect->isTablet())
        {
            $type = self::TYPE_TABLET;
        }
        elseif ($this->mobileDetect->isMobile())
        {
            $type = self::TYPE_MOBILE;
        }

        return $type;
    }

    /**
     * @return bool
     */
    public function isBot(): bool
    {
        return $this->crawlerDetect->isCrawler();
    }

    /**
     * @return bool
     */
    public function isTypeTablet(): bool
    {
        return $this->getType() === self::TYPE_TABLET;
    }

    /**
     * @return bool
     */
    public function isTypeMobile(): bool
    {
        return $this->getType() === self::TYPE_MOBILE;
    }

    /**
     * @return bool
     */
    public function isTypeFallback(): bool
    {
        return !$this->isTypeMobile() && !$this->isTypeTablet();
    }
}