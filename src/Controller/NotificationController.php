<?php
declare(strict_types=1);
/**
 * @author Paul Nganda <paulngandasmith@gmail.com>
 * Created at : 21/06/2023
 */

namespace PaulLab\NotificationBundle\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use PaulLab\NotificationBundle\Service\NotificationManager;

/**
 * Class NotificationController
 * @package PaulLab\NotificationBundle\Controller
 */
class NotificationController extends EasyAdminController
{
    public function __construct(private readonly NotificationManager $notificationManager){}
    public function markReadBatchAction(array $ids): void
    {
        $this->notificationManager->batchMarkAsRead($ids);
    }
}
