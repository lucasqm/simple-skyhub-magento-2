<?php 

namespace Resultate\Skyhub\Observer\Sales\Order;

use Resultate\Skyhub\Observer\Sales\Order\AbstractOrderObserver;
use Resultate\Skyhub\Model\SkyhubJob;

class Shipmed extends AbstractOrderObserver
{
    protected function process($status)
    {
        return $status == $this->helper->getStatusShipmed();
    }

    protected function getOrderStatus()
    {
        return SkyhubJob::ENTITY_TYPE_SALES_ORDER_SHIPMED;
    }
}