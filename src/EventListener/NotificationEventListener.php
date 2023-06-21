<?php
declare(strict_types=1);
/**
 * @author Paul Nganda <paulngandasmith@gmail.com>
 * Created at : 21/06/2023
 */

namespace PaulLab\NotificationBundle\EventListener;

use PaulLab\NotificationBundle\Entity\Notification;
use PaulLab\NotificationBundle\Event\NotificationEventInterface;
use PaulLab\NotificationBundle\Service\NotificationManager;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Class NotificationEventListener
 * @package App\Bundle\NotificationBundle\EventListener
 */
class NotificationEventListener
{
    /**
     * NotificationEventListener constructor.
     * @param NotificationManager $notificationManager
     */
    public function __construct(protected NotificationManager $notificationManager){}

    /**
     * @param NotificationEventInterface $event
     */
    public function onNotificationEvent(NotificationEventInterface $event): void
    {
        $this->notificationManager->save(
            $this->notificationManager->createNotification($event->getMessage(), $event->getLevel())
                ->setSource($event->getSource())
                ->setSendAt($event->getSendAt())
        );
    }

    /**
     * @param GenericEvent $event
     */
    public function onEasyAdminShow(GenericEvent $event): void
    {
        $notification = $event->getSubject();
        if (!$notification instanceof Notification) {
            return;
        }
        $this->notificationManager->markAsRead($notification);
    }
}
