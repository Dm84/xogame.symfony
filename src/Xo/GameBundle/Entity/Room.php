<?php

namespace Xo\GameBundle\Entity;

class Room {
    
    private $inviter_login = null;
    private $invitee_login = null;
    private $state = null;
    private $board = array();
    
    public function __construct($inviter, $invitee, $state) {
        
        $this->inviter_login = $inviter;
        $this->invitee_login = $invitee;
        $this->state = $state;    
    }
    
    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }
    
    public function makeMove($cell, $login)
    {    
        $curState = $this->getRoomState($login);        
        if ($curState->canMove)    { $this->board[$cell] = $curState->token; return true; }
        else { return false; }
    }
    
    private function CheckCombo($combo, $token)
    {
        
        $intersec = array_intersect_assoc($this->board, array_fill_keys($combo, $token));
        $result = count($intersec) === 3;
        
        return $result;
    }
    
    private function GetStateAsInviter($isGameover, $isEven)
    {
        $token = 'o';
        return $this->CalcState($isGameover, !$isEven, $token);
    }
    
    private function CalcState($isGameover, $isEven, $token)
    {
        if ($isEven)
        {            
            if ($isGameover)
            {
                return new RoomState($this->board, false, true, $token, RoomState::STATE_LOSS);
            }
            else
            {
                return new RoomState($this->board, true, false, $token, RoomState::STATE_YOUR_MOVE);
            }
        } 
        else
        {
            if ($isGameover)
            {
                return new RoomState($this->board, false, false, $token, RoomState::STATE_WIN);
            }
            else
            {
                return new RoomState($this->board, false, false, $token, RoomState::STATE_RIVALS_MOVE);                
            }            
        }
        
    }
    
    private function GetStateAsInvitee($isGameover, $isEven)
    {
        $token = 'x';
        return $this->CalcState($isGameover, $isEven, $token);
    }
    
    public function getRoomState($login)
    {        
        if (count($this->board) >= 9)
        {            
            return new RoomState($this->board, false, true, $this->invitee_login === $login ? 'x' : 'o', RoomState::STATE_DRAW); 
        }
        
        $combos = array(array(0, 1, 2), array(3, 4, 5), array(6, 7, 8), 
                        array(0, 3, 6), array(1, 4, 7), array(2, 5, 8),
                        array(0, 4, 8), array(2, 4, 6));    
        
        $isEven = count($this->board) % 2 == 0;
        
        $checkToken = $isEven ? 'o' : 'x';        
            
        $isGameover = false;
        foreach ($combos as $combo)
        {
            if ($this->CheckCombo($combo, $checkToken)) { $isGameover = true; break; }
        }
        
        $state = $this->invitee_login === $login ?
                $this->GetStateAsInvitee($isGameover, $isEven) : $this->GetStateAsInviter($isGameover, $isEven);
        
        return $state;
    }

}
