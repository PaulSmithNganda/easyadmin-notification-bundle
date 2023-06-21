<?php
declare(strict_types=1);
/**
 * @author Paul Nganda <paulngandasmith@gmail.com>
 * Created at : 21/06/2023
 */

namespace PaulLab\NotificationBundle\Command;

use InvalidArgumentException;
use PaulLab\NotificationBundle\Event\NotificationEvent;
use PaulLab\NotificationBundle\Service\NotificationManager;
use PaulLab\NotificationBundle\ValueObject\NotificationLevel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Throwable;

/**
 * Class CleanCommand
 * @package App\Bundle\NotificationBundle\Command
 */
class CleanCommand extends Command
{
    protected const NB_DAYS_ARG = 'nbdays';

    protected const FILTER_LEVEL = 'level';

    /**
     * @var string
     */
    protected static $defaultName = 'notification:delete-old';

    public function __construct(
        private readonly NotificationManager $notificationManager,
        private readonly EventDispatcherInterface $eventDispatcher
    )
    {
        parent::__construct();
    }

    /**
     * Configure
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    protected function configure(): void
    {
        $this
            ->addArgument(
                self::NB_DAYS_ARG,
                InputArgument::REQUIRED,
                'Number of days from which older notifications should be deleted.'
            )->addOption(
                self::FILTER_LEVEL,
                null,
                InputOption::VALUE_OPTIONAL,
                sprintf(
                    'Specify a filter to apply on notification level (%s)',
                    implode(', ', NotificationLevel::getValues())
                )
            )
            ->setDescription('Delete old notification')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.StaticAccess)
     * @throws Throwable
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $nbDays = $input->getArgument(self::NB_DAYS_ARG);
        if (! is_numeric($nbDays) || $nbDays <= 0) {
            throw new InvalidArgumentException(
                'Invalid number of days provided, expected non null positive value'
            );
        }

        $level = null;
        $option = $input->getOption(self::FILTER_LEVEL);
        if ($option !== null) {
            if (! NotificationLevel::hasValue($option)) {
                throw new InvalidArgumentException(
                    sprintf('Invalid notification level "%s" filter provided', $option)
                );
            }
            $level = NotificationLevel::byValue($option);
        }

        $count = $this->notificationManager->removeObsolete((int) $nbDays, $level);
        $this->eventDispatcher->dispatch(new NotificationEvent(
            NotificationLevel::INFO(),
            sprintf('%d notifications deleted', $count),
            self::$defaultName
        ));
        return 0;
    }
}
