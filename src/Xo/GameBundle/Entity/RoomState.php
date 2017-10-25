<?php

namespace Xo\GameBundle\Entity;

class RoomState {
    
    const STATE_YOUR_MOVE = 0;
    const STATE_RIVALS_MOVE = 1;
    const STATE_WIN = 2;
    const STATE_LOSS = 3;
    const STATE_DRAW = 4;
    
    /**
     *
     * @var array 
     */
    public $board = null;
    
    public $canMove = null;
    public $canReplay = null;
    public $message = null;
    public $token = null;
    public $code = 0;
    
    public function __construct($board, $canMove, $canReplay, $token, $code)
    {
        $this->board = $board;
        $this->canMove = $canMove;
        $this->canReplay = $canReplay;
        $this->token = $token;
        $this->code = $code; 
    }
    
}
