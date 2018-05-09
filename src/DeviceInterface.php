<?php

namespace Simplon\Device;

interface DeviceInterface
{
    /**
     * @return string
     */
    public function getModel(): string;
    /**
     * @return string
     */
    public function getType(): string;
    /**
     * @return bool
     */
    public function isBot(): bool;

    /**
     * @return bool
     */
    public function isTypeTablet(): bool;

    /**
     * @return bool
     */
    public function isTypeMobile(): bool;

    /**
     * @return bool
     */
    public function isTypeFallback(): bool;
}