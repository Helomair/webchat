<?php
namespace App\Services;

use Swoole\Http\Request;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;
use Illuminate\Support\Facades\Log;
use Hhxsv5\LaravelS\Swoole\WebSocketHandlerInterface;

class WebSocketHandler implements WebSocketHandlerInterface {

    public function __construct() {

    }

    // 建立連線
    public function onOpen(Server $server, Request $request) {
        Log::info('WebSocket 已連接： ' . $request->fd);
    }

    // 接收訊息
    public function onMessage(Server $server, Frame $frame) {
        // Frame is client, Frame fd is client id.
        Log::info('從 { $frame->fd } 接收資料： { $frame->data }.');

        // 遍歷所有已連線的client.
        foreach ($server->connections as $fd) {
            if (!$server->isEstablished($fd)) {
                continue; // 沒有連接的跳過
            }

            // 廣播消息給所有clients.
            $server->push($fd, $frame->data);
        }
    }

    // 關閉連線
    public function onClose(Server $server, $fd, $reactorId) {
        Log::info('WebSocket 已斷線： ' . $fd);
    }
}