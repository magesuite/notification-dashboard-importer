<?php
declare(strict_types=1);

namespace MageSuite\NotificationDashboardImporter\Observer;

class AddErrorNotification implements \Magento\Framework\Event\ObserverInterface
{
    protected \MageSuite\NotificationDashboardImporter\Model\NotificationManagement $notificationManagement;

    protected \Psr\Log\LoggerInterface $logger;

    public function __construct(
        \MageSuite\NotificationDashboardImporter\Model\NotificationManagement $notificationManagement,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->notificationManagement = $notificationManagement;
        $this->logger = $logger;
    }

    public function execute(\Magento\Framework\Event\Observer $observer): void
    {
        $step = $observer->getData('step');
        $error = $observer->getData('error');
        $message = __(
            'Error with import ID: \'%1\' on step \'%2\': %3',
            $step->getImportId(),
            $step->getIdentifier(),
            $error
        );

        try {
            $this->notificationManagement->addNotification((string)$message);
        } catch (\Exception $e) {
            $this->logger->error($e);
        }
    }
}
