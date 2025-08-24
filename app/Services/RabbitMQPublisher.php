<?php

namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQPublisher
{
    private ?AMQPStreamConnection $connection = null;
    private $channel = null;

    public function __construct()
    {
        if (!env('RABBITMQ_ENABLED', true)) {
            return; // désactivable via .env
        }

        // timeouts/heartbeat pour stabilité
        $host = env('RABBITMQ_HOST', 'PTK-MessageBroker');
        $port = (int) env('RABBITMQ_PORT', 5672);
        $user = env('RABBITMQ_USER', 'guest');
        $pass = env('RABBITMQ_PASSWORD', 'guest');
        $vhost = env('RABBITMQ_VHOST', '/');

        $connectionTimeout = (float) env('RABBITMQ_CONN_TIMEOUT', 3.0);
        $rwTimeout         = (float) env('RABBITMQ_RW_TIMEOUT', 3.0);
        $heartbeat         = (int)   env('RABBITMQ_HEARTBEAT', 30);

        $this->connection = new AMQPStreamConnection(
            $host, $port, $user, $pass, $vhost,
            false, 'AMQPLAIN', null, 'en_US',
            $connectionTimeout, $rwTimeout, null, false, $heartbeat
        );

        $this->channel = $this->connection->channel();
    }

    /**
     * Publie un message JSON sur la queue (default exchange).
     */
    public function publish(string $queue, array $data): void
    {
        if (!$this->channel) {
            // désactivé ou connexion KO
            \Log::warning('RabbitMQ publish skipped (no channel)');
            return;
        }

        // durable queue
        $this->channel->queue_declare($queue, false, true, false, false);

        $body = json_encode($data, JSON_UNESCAPED_UNICODE);
        // v2.x => constante dispo, v3.x => non => 2 (persistent)
$deliveryMode = \defined(AMQPMessage::class.'::DELIVERY_MODE_PERSISTENT')
    ? AMQPMessage::DELIVERY_MODE_PERSISTENT
    : 2;

$msg = new AMQPMessage(
    $body,
    [
        'content_type'  => 'application/json',
        'delivery_mode' => $deliveryMode,
    ]
);

        // default exchange '' -> route par nom de queue
        $this->channel->basic_publish($msg, '', $queue);
    }

    /**
     * Helper pour publier un évènement {event, data, ts}
     */
    public function publishEvent(string $queue, string $event, array $payload): void
    {
        $this->publish($queue, [
            'event' => $event,
            'data'  => $payload,
            'ts'    => now()->toIso8601String(),
        ]);
    }

    public function __destruct()
    {
        try { $this->channel?->close(); } catch (\Throwable $e) {}
        try { $this->connection?->close(); } catch (\Throwable $e) {}
    }
}
