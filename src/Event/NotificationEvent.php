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
 * Class NotificationEvent
 * @package App\Bundle\NotificationBundle\Event
 */
class NotificationEvent implements NotificationEventInterface
{
    use NotificationEventTrait;

    public function __construct(
        NotificationLevel $level,
        string $message,
        ?string $source = null,
        ?DateTimeInterface $sendAt = null
    ) {
        $this->level = $level;
        $this->message = $message;
        $this->source = $source;
        $this->sendAt = $sendAt;
    }
}
