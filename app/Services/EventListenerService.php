<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class EventListenerService
{
    private MessageBrokerService $messageBroker;

    public function __construct()
    {
        $this->messageBroker = new MessageBrokerService();
    }

    public function startListening(): void
    {
        $this->messageBroker->consumeEvents(
            'products_service_queue',
            'payetonkawa',
            ['order.created'],
            function (array $data, string $routingKey) {
                $this->handleEvent($data, $routingKey);
            }
        );
    }

    private function handleEvent(array $data, string $routingKey): void
    {
        switch ($routingKey) {
            case 'order.created':
                $this->handleOrderCreated($data);
                break;
            default:
                Log::warning("Unknown event type: {$routingKey}");
        }
    }

    private function handleOrderCreated(array $data): void
    {
        Log::info("Products service: Order created", [
            'order_id' => $data['order_id'],
            'customer_id' => $data['customer_id'],
            'items' => $data['items']
        ]);

        if (isset($data['items']) && is_array($data['items'])) {
            foreach ($data['items'] as $item) {
                if (isset($item['product_id'], $item['quantity'])) {
                    $this->updateStock($item['product_id'], $item['quantity']);
                }
            }
        }
    }

    private function updateStock(int $productId, int $quantity): void
    {
        Log::info("Updating stock for product", [
            'product_id' => $productId,
            'quantity_sold' => $quantity
        ]);
    }
}
