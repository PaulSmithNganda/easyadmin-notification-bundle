<?php
declare(strict_types=1);
/**
 * @author Paul Nganda <paulngandasmith@gmail.com>
 * Created at : 21/06/2023
 */

namespace PaulLab\NotificationBundle\Event;

use PaulLab\NotificationBundle\ValueObject\NotificationLevel;
use DateTimeInterface;

/**
 * Interface NotificationEventInterface
 * @package App\Bundle\NotificationBundle\Event
 */
interface NotificationEventInterface
{
    public function getLevel(): NotificationLevel;

    public function getSource(): ?string;

    public function getMessage(): string;

    public function getSendAt(): ?DateTimeInterface;
}
