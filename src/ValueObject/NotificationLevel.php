<?php
declare(strict_types=1);
/**
 * @author Paul Nganda <paulngandasmith@gmail.com>
 * Created at : 21/06/2023
 */

namespace PaulLab\NotificationBundle\ValueObject;

use PaulLab\NotificationBundle\Abstract\EnumAbstract;

/**
 * Class NotificationLevel
 * @package App\ValueObject
 * @method static NotificationLevel SUCCESS();
 * @method static NotificationLevel INFO();
 * @method static NotificationLevel WARNING();
 * @method static NotificationLevel DANGER();
 * @method string getValue();
 * @psalm-immutable
 * @extends EnumAbstract<string>
 */
class NotificationLevel extends EnumAbstract
{
    public const SUCCESS = 'success';
    public const INFO    = 'info';
    public const WARNING = 'warning';
    public const DANGER  = 'danger';

    public function __toString(): string
    {
        $value = $this->getValue();
        if (is_string($value)) {
            return $value;
        }
        return parent::__toString();
    }

    public function toScalar(): string
    {
        return $this->getValue();
    }
}
