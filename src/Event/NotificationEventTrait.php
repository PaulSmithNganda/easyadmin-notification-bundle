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
 * Trait NotificationEventTrait
 * @package App\Bundle\NotificationBundle\Event
 */
trait NotificationEventTrait
{
    protected NotificationLevel $level;

    protected ?string $source;

    protected string $message = '';

    protected ?DateTimeInterface $sendAt;

    /**
     * @return NotificationLevel
     */
    public function getLevel(): NotificationLevel
    {
        return $this->level;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getSendAt(): ?DateTimeInterface
    {
        return $this->sendAt;
    }
}
