<?php

namespace services\MobileDetector;


class MobileDetectorService implements MobileDetectorInterface
{
    /**
     * @var \Detection\MobileDetect
     */
    private $mobileDetector;

    public function __construct()
    {
        $this->mobileDetector = new \Detection\MobileDetect;
    }

    /**
     * @return bool
     */
    public function isMobile(): bool
    {
        return $this->mobileDetector->isMobile();
    }

    /**
     * @return bool
     */
    public function isTablet(): bool
    {
        return $this->mobileDetector->isTablet();
    }
}