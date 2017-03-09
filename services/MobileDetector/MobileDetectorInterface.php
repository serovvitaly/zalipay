<?php

namespace services\MobileDetector;


interface MobileDetectorInterface
{
    /**
     * @return bool
     */
    public function isMobile(): bool;

    /**
     * @return bool
     */
    public function isTablet(): bool;
}