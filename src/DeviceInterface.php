<?php

namespace Simplon\Device;

interface DeviceInterface
{
    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return bool
     */
    public function isCrawler(): bool;

    /**
     * @return bool
     */
    public function isTablet(): bool;

    /**
     * @return bool
     */
    public function isMobile(): bool;

    /**
     * @return bool
     */
    public function isDesktop(): bool;
}