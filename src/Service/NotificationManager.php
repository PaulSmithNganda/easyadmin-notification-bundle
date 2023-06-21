<?php
declare(strict_types=1);
/**
 * @author Paul Nganda <paulngandasmith@gmail.com>
 * Created at : 21/06/2023
 */

namespace PaulLab\NotificationBundle\Service;

use DateInterval;
use DateTime;
use Exception;
use PaulLab\NotificationBundle\Entity\Notification;
use PaulLab\NotificationBundle\Repository\NotificationRepository;
use PaulLab\NotificationBundle\ValueObject\NotificationLevel;

/**
 * Class NotificationService
 * @package App\Bundle\NotificationBundle\Service
 */
class NotificationManager
{
    protected DateTime $clock;

    /**
     * NotificationService constructor.
     * @param NotificationRepository $repository
     */
    public function __construct(protected NotificationRepository $repository)
    {
        $this->clock = new DateTime();
    }

    /**
     * @param string                 $message
     * @param NotificationLevel|null $level
     * @return Notification
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function createNotification(string $message, ?NotificationLevel $level): Notification
    {
        return (new Notification())
            ->setMessage($message)
            ->setLevel($level ?: NotificationLevel::INFO());
    }

    /**
     * @param Notification $notification
     * @return Notification
     */
    public function save(Notification $notification): Notification
    {
        if ($notification->getSendAt() === null) {
            $notification->setSendAt($this->clock);
        }
        $this->repository->save($notification);
        return $notification;
    }

    /**
     * @param Notification $notification
     * @return Notification
     */
    public function markAsRead(Notification $notification): Notification
    {
        $notification->markRead($this->clock);
        $this->repository->save($notification);
        return $notification;
    }

    /**
     * @param array $ids
     * @return $this
     */
    public function batchMarkAsRead(array $ids): self
    {
        foreach ($ids as $id) {
            /** @var Notification|null $notification */
            $notification = $this->repository->find($id);
            if (null === $notification) {
                continue;
            }
            $this->markAsRead($notification);
        }
        return $this;
    }

    /**
     * @param int $nbDays
     * @param NotificationLevel|null $level
     * @return int
     * @throws Exception
     */
    public function removeObsolete(int $nbDays, ?NotificationLevel $level = null): int
    {
        return $this->repository->deleteOlderThan(
            $this->clock
                ->sub(new DateInterval(sprintf('P%sD', $nbDays))),
            $level
        );
    }
}
