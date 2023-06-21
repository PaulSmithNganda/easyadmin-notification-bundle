<?php
declare(strict_types=1);
/**
 * @author Paul Nganda <paulngandasmith@gmail.com>
 * Created at : 21/06/2023
 */

namespace PaulLab\NotificationBundle;

use PaulLab\NotificationBundle\DependencyInjection\NotificationBundleExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class PaulLabNotificationBundle
 * @package PaulLab\NotificationBundle
 */
class PaulLabNotificationBundle extends Bundle
{
    /**
     * @return NotificationBundleExtension|ExtensionInterface|null
     */
    public function getContainerExtension(): ExtensionInterface|NotificationBundleExtension|null
    {
        return new NotificationBundleExtension();
    }
}
