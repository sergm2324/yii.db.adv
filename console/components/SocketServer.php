<?php


namespace console\components;


use frontend\models\tables\Chat;
use frontend\models\tables\Comments;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Ratchet\WebSocket\WsConnection;


class SocketServer implements MessageComponentInterface
{

    private $clients = [];

    /**
     * Chat constructor.
     */
    public function __construct()
    {
        echo "Server started\n";
    }

    /**
     * @param WsConnection $conn
     */
    function onOpen(ConnectionInterface $conn)
    {
        $queryString =  $conn->httpRequest->getUri()->getQuery();
        $channel = explode('=', $queryString)[1];

        $this->clients[$channel][$conn->resourceId] = $conn;
        echo "New connextion: {$conn->resourceId}";
    }

    /**
     * @param WsConnection $conn
     */
    function onClose(ConnectionInterface $conn)
    {
        unset($this->clients[$conn->resourceId]);
    }

    /**
     * @param WsConnection $conn
     */
    function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo $e->getMessage() . PHP_EOL;
        $conn->close();
        unset($this->clients[$conn->resourceId]);
    }

    /**
     * @param WsConnection $from
     * @param string $msg {user_id : 1, message : '', channel: '1'}
     */
    function onMessage(ConnectionInterface $from, $msg)
    {
        $model = new Comments();
        // Принимаем сообщение от клиента и декодируем
        $data = json_decode($msg, true);
        echo "{$from->resourceId} say: {$data['message']}\n";

        $channel = $data['channel'];
        $username = \common\models\User::findOne($data['user_id'])->username;
        $model->user_id =$data['user_id'];
        $model->task_id=$data['channel'];
        $model->name = $data['message'];
        //$model->created_at = date('Y-m-d h:m:s', time());
        $model->save();

        $message = $username.": ".$data['message'];

        foreach ($this->clients[$channel] as $client){
            $client->send($message);
        }
    }
}