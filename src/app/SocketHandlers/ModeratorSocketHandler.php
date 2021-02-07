<?php


namespace App\SocketHandlers;


use App\Events\NewQuestion;
use BeyondCode\LaravelWebSockets\Apps\App;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;

class ModeratorSocketHandler implements \Ratchet\WebSocket\MessageComponentInterface
{
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage();
    }

    /**
     * @inheritDoc
     */
    function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        $socketId = sprintf('%d.%d', random_int(1, 1000000000), random_int(1, 1000000000));
        $conn->socketId = $socketId;
        $conn->app = App::findById(env('PUSHER_APP_ID'));
        echo "New mod connection! ({$conn->resourceId})\n";
    }

    /**
     * @inheritDoc
     */
    function onClose(ConnectionInterface $conn)
    {
        // TODO: Implement onClose() method.
    }

    /**
     * @inheritDoc
     */
    function onError(ConnectionInterface $conn, \Exception $e)
    {
        // TODO: Implement onError() method.
    }

    public function onMessage(ConnectionInterface $conn, MessageInterface $msg)
    {
        if($data = json_decode($msg)) {
            if(property_exists($data, 'action')){
                switch($data->action) {
                    case 'login':
                        $this->doLogin($conn, $data->data);
                        break;
                    case 'checkLogin':
                        $this->checkLogin($conn);
                        break;
                    default:
                }
            }else{
                $this->returnError($conn, 'Action parameter missing');
            }
        }else{
            $this->returnError($conn, 'Invalid payload');
        }
    }

    protected function checkLogin(ConnectionInterface $conn)
    {
        if(auth()->check()){
            $this->returnSuccess($conn, ['message' => 'Logged in']);
        }else{
            $this->returnError($conn, 'Nope, not logged in');
        }
    }

    protected function doLogin(ConnectionInterface $conn, $creds)
    {
        if(auth()->attempt([
            'email' => $creds->email,
            'password' => $creds->password
        ]))
        {
            $this->returnSuccess($conn, ['message' => 'Successful login']);
        }else{
            $this->returnError($conn, 'Wrong login credentials');
        }
    }

    protected function returnSuccess(ConnectionInterface $conn, $payload)
    {
        $conn->send(json_encode(['success' => true, 'data' => $payload, 'login_state' => auth()->check()]));
    }

    public function returnError(ConnectionInterface $conn, String $message)
    {
        $conn->send(json_encode(['success' => false, 'error' => $message, 'login_state' => auth()->check()]));
    }
}
