<?php

namespace Simplon\Device;

use DeviceDetector\DeviceDetector;

/**
 * Class Device
 * @package Simplon\Device
 */
class Device
{
    const MODEL_FALLBACK = 'FALLBACK';
    const MODEL_IOS = 'IOS';
    const MODEL_ANDROID = 'ANDROID';

    const TYPE_FALLBACK = 'FALLBACK';
    const TYPE_TABLET = 'TABLET';
    const TYPE_MOBILE = 'MOBILE';

    /**
     * @var DeviceDetector
     */
    private $detector;

    /**
     * @param string|null $agent
     */
    public function __construct(string $agent = null)
    {
        if ($agent === null && !empty($_SERVER['HTTP_USER_AGENT']))
        {
            $agent = $_SERVER['HTTP_USER_AGENT'];
        }

        $this->detector = new DeviceDetector($agent);
        $this->detector->parse();
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        $model = self::MODEL_FALLBACK;
        $osName = null;

        if ($osName = isset($this->detector->getOs()['name']))
        {
            $osName = strtolower($this->detector->getOs()['name']);
        }

        if ($osName === 'ios')
        {
            $model = self::MODEL_IOS;
        }
        elseif ($osName === 'android')
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

        if ($this->detector->isTablet())
        {
            $type = self::TYPE_TABLET;
        }
        elseif ($this->detector->isMobile())
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
        return $this->detector->isBot();
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