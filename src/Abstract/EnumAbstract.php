<?php
declare(strict_types=1);
/**
 * @author Paul Nganda <paulngandasmith@gmail.com>
 * Created at : 21/06/2023
 */

namespace PaulLab\NotificationBundle\Abstract;

use JsonSerializable;
use MabeEnum\Enum;
use PaulLab\NotificationBundle\ValueObject\ValueObject;

/**
 * Class EnumAbstract
 * @package PaulNganda\AdvancedTypes\Enum
 * @psalm-immutable
 * @template T2
 * @implements ValueObject<T2>
 */
abstract class EnumAbstract extends Enum implements JsonSerializable, ValueObject
{
    public function jsonSerialize(): mixed
    {
        return $this->getValue();
    }

    public function __toString(): string
    {
        $value = $this->getValue();
        if (is_string($value)) {
            return $value;
        }
        return parent::__toString();
    }
}
