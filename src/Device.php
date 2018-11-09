<?php

namespace Simplon\Device;

use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Simplon\Interfaces\StorageInterface;

class Device implements DeviceInterface
{
    const MODEL_FALLBACK = 'FALLBACK';
    const MODEL_IOS = 'IOS';
    const MODEL_ANDROID = 'ANDROID';

    const TYPE_FALLBACK = 'FALLBACK';
    const TYPE_TABLET = 'TABLET';
    const TYPE_MOBILE = 'MOBILE';

    const STORAGE_NAMESPACE = 'device-detection';
    const STORAGE_KEY_MODEL = 'model';
    const STORAGE_KEY_TYPE = 'type';
    const STORAGE_KEY_BOT = 'bot';

    /**
     * @var \Mobile_Detect
     */
    private $mobileDetect;
    /**
     * @var CrawlerDetect
     */
    private $crawlerDetect;
    /**
     * @var StorageInterface|null
     */
    private $storage;
    /**
     * @var string
     */
    private $model;
    /**
     * @var string
     */
    private $type;
    /**
     * @var bool
     */
    private $isBot;

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
     * @return StorageInterface|null
     */
    public function getStorage(): ?StorageInterface
    {
        return $this->storage;
    }

    /**
     * @param StorageInterface $storage
     *
     * @return Device
     */
    public function setStorage(StorageInterface $storage): Device
    {
        $this->storage = $storage;

        return $this;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        if ($this->hasStorage() && $model = $this->fetchStoredValue(self::STORAGE_KEY_MODEL))
        {
            return $model;
        }

        if (!$this->model)
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

            if ($this->hasStorage())
            {
                $this->setStoredValue(self::STORAGE_KEY_MODEL, $model);
            }

            $this->model = $model;
        }

        return $this->model;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        if ($this->hasStorage() && $type = $this->fetchStoredValue(self::STORAGE_KEY_TYPE))
        {
            return $type;
        }

        if (!$this->type)
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

            if ($this->hasStorage())
            {
                $this->setStoredValue(self::STORAGE_KEY_TYPE, $type);
            }

            $this->type = $type;
        }

        return $this->type;
    }

    /**
     * @return bool
     */
    public function isBot(): bool
    {
        if ($this->hasStorage() && $isBot = $this->fetchStoredValue(self::STORAGE_KEY_BOT))
        {
            return $isBot;
        }

        if ($this->isBot === null)
        {
            $this->isBot = $this->crawlerDetect->isCrawler();

            if ($this->hasStorage())
            {
                $this->setStoredValue(self::STORAGE_KEY_BOT, $this->isBot);
            }
        }

        return $this->isBot;
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

    /**
     * @return bool
     */
    private function hasStorage(): bool
    {
        return $this->getStorage() !== null;
    }

    /**
     * @param string $key
     *
     * @return mixed|null
     */
    private function fetchStoredValue(string $key)
    {
        return $this->getStorage()->get(self::STORAGE_NAMESPACE . '-' . $key);
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return Device
     */
    private function setStoredValue(string $key, $value): self
    {
        $this->getStorage()->set(self::STORAGE_NAMESPACE . '-' . $key, $value);

        return $this;
    }
}