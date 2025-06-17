<?php

namespace App\Events;

use App\Services\MessageBrokerService;

class ProductUpdatedEvent
{
    private MessageBrokerService $messageBroker;

    public function __construct()
    {
        $this->messageBroker = new MessageBrokerService();
    }

    public function publish(array $productData): void
    {
        $this->messageBroker->publishEvent(
            'payetonkawa',
            'product.updated',
            [
                'product_id' => $productData['id'],
                'name' => $productData['name'],
                'price' => $productData['price'],
                'stock_quantity' => $productData['stock_quantity'] ?? 0,
                'updated_at' => now()->toISOString(),
                'event_type' => 'product_updated'
            ]
        );
    }
}
