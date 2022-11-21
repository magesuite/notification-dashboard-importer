<?php
declare(strict_types=1);

namespace MageSuite\NotificationDashboardImporter\Setup\Patch\Data;

class AddImportNotificationCollector implements \Magento\Framework\Setup\Patch\DataPatchInterface
{
    protected \MageSuite\NotificationDashboard\Api\Data\CollectorInterfaceFactory $collectorFactory;

    protected \MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository;

    public function __construct(
        \MageSuite\NotificationDashboard\Api\Data\CollectorInterfaceFactory $collectorFactory,
        \MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository
    ) {
        $this->collectorFactory = $collectorFactory;
        $this->collectorRepository = $collectorRepository;
    }

    public function apply(): self
    {
        $collector = $this->collectorFactory->create()
            ->setName(\MageSuite\NotificationDashboardImporter\Model\NotificationManagement::COLLECTOR_NAME)
            ->setIsEnabled(1)
            ->setSeverity(\MageSuite\NotificationDashboard\Model\Source\Severity::SEVERITY_CRITICAL)
            ->setLimitOnDashboard(10)
            ->setAddAdminNotification(0)
            ->setVisibleOnDashboard(1)
            ->setIsStatic(0);
        $this->collectorRepository->save($collector);

        return $this;
    }

    public function getAliases(): array
    {
        return [];
    }

    public static function getDependencies(): array
    {
        return [];
    }
}
