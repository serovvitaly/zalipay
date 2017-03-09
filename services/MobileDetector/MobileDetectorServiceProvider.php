<?php

namespace services\MobileDetector;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class MobileDetectorServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $app A container instance
     */
    public function register(Container $app)
    {
        $app['mobile_detector'] = function() {
            $mobileDetectorService = new \services\MobileDetector\MobileDetectorService;
            if (!is_a($mobileDetectorService, \services\MobileDetector\MobileDetectorInterface::class)) {
                throw new \Exception('MobileDetectorService does not implement a MobileDetectorInterface');
            }
            return $mobileDetectorService;
        };
    }
}