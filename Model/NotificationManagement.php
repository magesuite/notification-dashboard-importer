<?php
declare(strict_types=1);

namespace MageSuite\NotificationDashboardImporter\Model;

class NotificationManagement
{
    public const COLLECTOR_NAME = 'Product Import';

    protected \MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository;

    protected \MageSuite\NotificationDashboard\Model\Command\Notification\AddNotification $addNotification;

    public function __construct(
        \MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository,
        \MageSuite\NotificationDashboard\Model\Command\Notification\AddNotification $addNotification
    ) {
        $this->collectorRepository = $collectorRepository;
        $this->addNotification = $addNotification;
    }

    public function addNotification(string $message): void
    {
        $this->addNotification->execute(
            $message,
            $this->getCollector()->getId(),
            $this->getCollector()->getSeverity()
        );
    }

    public function getCollector(): \MageSuite\NotificationDashboard\Api\Data\CollectorInterface
    {
        return $this->collectorRepository->get(self::COLLECTOR_NAME);
    }
}
