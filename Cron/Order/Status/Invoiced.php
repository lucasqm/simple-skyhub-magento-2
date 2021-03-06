<?php

namespace Resultate\Skyhub\Cron\Order\Status;

use Resultate\Skyhub\Cron\Order\AbstractOrderCron;
use Resultate\Skyhub\Model\SkyhubJob;

class Invoiced extends AbstractOrderCron
{
    protected function processJob(SkyhubJob $job)
    {
        try{
            $orderId = $job->getEntityId();
            $order = $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderId);

            if($order->hasData('skyhub_id'))
            {
                /**
                 * @todo $nfKey
                 */
                $nfKey    = '99999999999999999999999999999999999999999999';
                $skyhubId = $order->getData('skyhub_id');
                $response = $this->getRequestHandler()->invoice($skyhubId, $nfKey);

                if ($response->success())
                {
                    echo 'Order Invoiced: ' . $skyhubId . PHP_EOL;
                }
            }
        }catch(\Exception $e){
            echo 'Error: ' . $orderId  . PHP_EOL;
            print_r($e->getMessage());
            $this->logger->critical($e);
        }
    }

    protected function setJobType()
    {
        return $this->jobType = SkyhubJob::ENTITY_TYPE_SALES_ORDER_INVOICED;
    }
}