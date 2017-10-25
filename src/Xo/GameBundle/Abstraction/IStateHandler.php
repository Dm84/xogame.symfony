<?php

namespace Xo\GameBundle\Abstraction;

 interface IStateHandler {

    /**
     * @return string
     */
    public function HandleSignin();
    
    /**
     * @return string
     */
    public function HandleLobby();
    
    /**
     * 
     * @param type $inviter
     * @return string
     */
    public function HandleInvited($inviter);
    
    /**
     * 
     * @param type $invitee
     * @return string
     */
    public function HandleAwaiting($invitee);

    /**
     * 
     * @param \Xo\GameBundle\Entity\RoomState $state
     * @return string
     */
    public function HandleLeft(\Xo\GameBundle\Entity\RoomState $state);
    
    /**
     * 
     * @param \Xo\GameBundle\Entity\RoomState $state
     * @return string
     */
    public function HandleBoard(\Xo\GameBundle\Entity\RoomState $state);
         
//    public function SetRoom(& $room);
//    
//    public function HandleError();    
//    public function HandleCanMove();
//    public function HandleWaitMove();
//    public function HandleLoss();
//    public function HandleWin();    
//    public function HandleDraw();
    
    //public function HandleDeclined();
    //public function HandleInvited();

}

