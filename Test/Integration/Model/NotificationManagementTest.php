<?php
declare(strict_types=1);

namespace MageSuite\NotificationDashboardImporter\Test\Integration\Model;

class NotificationManagementTest extends \PHPUnit\Framework\TestCase
{
    protected ?\MageSuite\NotificationDashboardImporter\Model\NotificationManagement $notificationManagement = null;

    protected ?\MageSuite\NotificationDashboard\Api\NotificationRepositoryInterface $notificationRepository = null;

    protected function setUp(): void
    {
        $objectManager = \Magento\TestFramework\ObjectManager::getInstance();
        $this->notificationManagement = $objectManager->get(\MageSuite\NotificationDashboardImporter\Model\NotificationManagement::class);
        $this->notificationRepository = $objectManager->get(\MageSuite\NotificationDashboard\Api\NotificationRepositoryInterface::class);
    }

    /**
     * @magentoAppIsolation enabled
     * @magentoDbIsolation enabled
     * @return void
     */
    public function testIfNotificationWasAdded(): void
    {
        $message = 'Dummy notification';
        $this->notificationManagement->addNotification($message);
        $items = $this->notificationRepository->getList()->getItems();
        $notification = array_pop($items);
        $this->assertEquals($message, $notification->getMessage());
    }
}
