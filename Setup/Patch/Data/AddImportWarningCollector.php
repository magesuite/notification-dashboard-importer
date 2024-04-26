<?php
declare(strict_types=1);

namespace MageSuite\NotificationDashboardImporter\Setup\Patch\Data;

class AddImportWarningCollector implements \Magento\Framework\Setup\Patch\DataPatchInterface
{
    public const COLLECTOR_NAME = 'Import Warning';

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
            ->setName(self::COLLECTOR_NAME)
            ->setIsEnabled(1)
            ->setSeverity(\MageSuite\NotificationDashboard\Model\Source\Severity::SEVERITY_MAJOR)
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
