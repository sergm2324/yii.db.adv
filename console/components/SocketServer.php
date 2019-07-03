<?php


namespace console\components;


use frontend\models\tables\Comments;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Ratchet\WebSocket\WsConnection;
use Yii;

class SocketServer implements MessageComponentInterface
{

    /** @var  WsConnection[]*/
    private $clients = [];

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        echo "server started\n";
    }

    /**
     * @param WsConnection $conn
     */
    function onOpen(ConnectionInterface $conn)
    {
        //$this->clients[$conn->resourceId] = $conn;
        $this->clients->attach($conn);
        echo "New connection : {$conn->resourceId}\n";
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
     */
    function onMessage(ConnectionInterface $from, $msg)
    {

        $model = new Comments();
        // Принимаем сообщение от клиента и декодируем
        $msg = json_decode($msg, true);
        echo "{$from->resourceId} say: {$msg['text']}\n";

        $username = $msg['username'];
        $model->user_id =$msg['user_id'];
        $model->task_id=$msg['task_id'];
        $model->name = $msg['text'];
        $text = $msg['text'];
        $model->save();
        $message = $username.": ".$text;

        foreach ($this->clients as $client){
            $client->send($message );
        }
    }


}