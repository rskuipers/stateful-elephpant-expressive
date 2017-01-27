<?php
declare(strict_types=1);

namespace App\StateMachine;

use App\Model\Order;
use SM\Factory\Factory;

final class StateMachineFactoryFactory
{
    public function __invoke()
    {
        $config = [
            'class'         => Order::class,
            'graph'         => 'default',
            'property_path' => 'status',
            'states'        => [
                Order::STATUS_NEW,
                Order::STATUS_PENDING,
                Order::STATUS_COMPLETED,
                Order::STATUS_CANCELED,
                Order::STATUS_REFUNDED,
            ],
            'transitions' => [
                'create' => [
                    'from' => [Order::STATUS_NEW],
                    'to'   => Order::STATUS_PENDING,
                ],
                'cancel' => [
                    'from' => [Order::STATUS_NEW, Order::STATUS_PENDING],
                    'to'   => Order::STATUS_CANCELED,
                ],
                'complete' => [
                    'from' => [Order::STATUS_PENDING],
                    'to'   => Order::STATUS_COMPLETED,
                ],
                'refund' => [
                    'from' => [Order::STATUS_COMPLETED],
                    'to'   => Order::STATUS_REFUNDED,
                ],
            ],
        ];

        return new Factory([$config]);
    }
}
