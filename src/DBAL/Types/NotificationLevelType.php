<?php
declare(strict_types=1);
/**
 * @author Paul Nganda <paulngandasmith@gmail.com>
 * Created at : 21/06/2023
 */

namespace PaulLab\NotificationBundle\DBAL\Types;

use PaulLab\NotificationBundle\ValueObject\NotificationLevel;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * Class NotificationLevelType
 * @package App\Doctrine\Type
 */
class NotificationLevelType extends Type
{
    protected const TYPE_NAME = 'notification_level';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function getName(): string
    {
        return self::TYPE_NAME;
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return NotificationLevel
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): NotificationLevel
    {
        return NotificationLevel::byValue($value);
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return mixed
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value instanceof NotificationLevel)
            $value = $value->getValue();

        return $value;
    }
}
