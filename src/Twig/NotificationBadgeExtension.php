<?php
declare(strict_types=1);
/**
 * @author Paul Nganda <paulngandasmith@gmail.com>
 * Created at : 21/06/2023
 */

namespace PaulLab\NotificationBundle\Twig;

use PaulLab\NotificationBundle\Repository\NotificationRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class NotificationBadgeExtension
 * @package App\Bundle\NotificationBundle\Twig
 */
class NotificationBadgeExtension extends AbstractExtension
{
    /**
     * NotificationBadgeExtension constructor.
     * @param NotificationRepository $repository
     */
    public function __construct(protected NotificationRepository $repository) {}

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('notification_badge', [$this, 'getBadges'], ['is_safe' => ['html']])
        ];
    }

    /**
     * @return string
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getBadges(): string
    {
        $nbUnread = $this->repository->countUnread();
        if ($nbUnread === 0) {
            return '';
        }
        return sprintf('<span class="badge badge-success">%d</span>', $nbUnread);
    }
}
