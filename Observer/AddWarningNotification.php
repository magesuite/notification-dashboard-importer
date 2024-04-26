<?php

declare(strict_types=1);

namespace MageSuite\NotificationDashboardImporter\Observer;

class AddWarningNotification implements \Magento\Framework\Event\ObserverInterface
{
    protected \MageSuite\NotificationDashboardImporter\Model\NotificationManagement $notificationManagement;

    public function __construct(
        \MageSuite\NotificationDashboardImporter\Model\NotificationManagement $notificationManagement,
    ) {
        $this->notificationManagement = $notificationManagement;
    }

    public function execute(\Magento\Framework\Event\Observer $observer): void
    {
        /** @var \MageSuite\Importer\Model\ImportStep $step */
        $step = $observer->getData('step');
        $output = $observer->getData('output');

        if (!$output instanceof \MageSuite\Importer\Model\Command\Output) {
            return;
        }

        if ($output->getStatus() != \MageSuite\Importer\Model\ImportStep::STATUS_DONE) {
            $this->notificationManagement->addNotification(
                "Warning! Step '{$step->getIdentifier()}' of import #{$step->getImportId()} has finished with errors:\n{$output->getMessage()}",
                \MageSuite\NotificationDashboardImporter\Setup\Patch\Data\AddImportWarningCollector::COLLECTOR_NAME
            );
        }
    }
}
