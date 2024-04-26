<?php

declare(strict_types=1);

namespace MageSuite\NotificationDashboardImporter\Model;

class NotificationManagement
{
    protected \MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository;
    protected \MageSuite\NotificationDashboard\Model\Command\Notification\AddNotification $addNotification;

    public function __construct(
        \MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository,
        \MageSuite\NotificationDashboard\Model\Command\Notification\AddNotification $addNotification
    ) {
        $this->collectorRepository = $collectorRepository;
        $this->addNotification = $addNotification;
    }

    public function addNotification(
        string $message,
        string $collectorName = \MageSuite\NotificationDashboardImporter\Setup\Patch\Data\AddImportNotificationCollector::COLLECTOR_NAME
    ): void {
        $collector = $this->getCollector($collectorName);
        $this->addNotification->execute(
            $message,
            $collector->getId(),
            $collector->getSeverity()
        );
    }

    public function getCollector(string $collectorName): \MageSuite\NotificationDashboard\Api\Data\CollectorInterface
    {
        return $this->collectorRepository->get($collectorName);
    }
}
