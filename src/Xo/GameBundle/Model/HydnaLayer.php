<?php

namespace Xo\GameBundle\Model;

use Doctrine\ORM\EntityManager;
use Xo\GameBundle\Model;
use Xo\GameBundle\Abstraction;
use Xo\GameBundle\Entity;
use Symfony\Component\Stopwatch\Stopwatch;

require_once(__DIR__."/hydna-push.php");

class Notice {

    /**
     * 
     * @var string
     */
    public $type = null;    
    
    public $body = null;

    /**
     * 
     * @param string $type
     */
    public function __construct($type) {
        $this->type = $type;
        $this->body = new \stdClass();
    }

    public function Broadcast(\Hydna & $hydna)
    {
        $json = json_encode($this);
        error_log('hydna broadcast push: '.$json);
        $hydna->push("http://xoapp.hydna.net/shared", $json);
    }

    public function SendTo($addressee, \Hydna & $hydna)
    {
        $json = json_encode($this);
        error_log('hydna push to '.$addressee.': '.$json);
        $hydna->push("http://xoapp.hydna.net/user/$addressee", $json);
    }
}

/**
 * Слой модели, предназначенный для рассылки уведомлений клиентам
 * @author admin
 *
 */
class HydnaLayer extends Model\Game {

    private $stopwatch;
    private $hydna;

    /**
     * 
     * @param string $locale
     * @param EntityManager $em
     * @param Stopwatch $stopwatch
     * @param string $login
     * @param string $hash
     */
    public function __construct($locale, EntityManager & $em, $stopwatch, 
                                $login = null, $hash = null)
    {
        parent::__construct($locale, $em, $stopwatch, $login, $hash);

        $this->stopwatch = $stopwatch;
        $this->hydna = new \Hydna();
    }

    public function Invite($invitee) {

        parent::Invite($invitee);

        $notice = new Notice('invited');
        $notice->body->inviter = $this->login;
        $notice->SendTo($invitee, $this->hydna);
    }

    public function Decline() {

        $inviterLogin = parent::Decline();

        $notice = new Notice('declined');
        $notice->body->invitee = $this->login;
        $notice->SendTo($inviterLogin, $this->hydna);

        return $inviterLogin;
    }

    public function Cancel()
    {
        $inviteeLogin = parent::Cancel();

        $notice = new Notice('canceled');
        $notice->body->inviter = $this->login;
        $notice->SendTo($inviteeLogin, $this->hydna);

        return $inviteeLogin;
    }

    public function LeaveRoomIfPlaying()
    {
        $remainingPlayer = parent::LeaveRoomIfPlaying();

        if ($remainingPlayer !== false) {
            $leaveMessage = new Notice('leave_game');
            $leaveMessage->SendTo($remainingPlayer, $this->hydna);
        }

        return $remainingPlayer;
    }

    public function KeepAlive()
    {
        parent::KeepAlive();

        $notice = new Notice('player_online');
        $notice->body->login = $this->login;
        $notice->Broadcast($this->hydna);
    }

    public function Accept()
    {
        $inviterLogin = parent::Accept();

        $notice = new Notice('accepted');
        $notice->body->invitee = $this->login;
        $notice->SendTo($inviterLogin, $this->hydna);

        return $inviterLogin;
    }

    public function RemoveInactivePlayers()
    {
        $leftLogins = parent::RemoveInactivePlayers();

        if (count($leftLogins))
        {
            $notice = new Notice('leaved');
            $notice->body->logins = $leftLogins;
            $notice->Broadcast($this->hydna);
        }

        return $leftLogins;
    }

    public function Replay()
    {
        $outRivalLogin = parent::Replay();

        $notice = new Notice('accept_replay');
        $notice->SendTo($outRivalLogin, $this->hydna);

        return $outRivalLogin;
    }

    public function LeaveLobby() {

        parent::LeaveLobby();

        $notice = new Notice('leaved');
        $notice->body->logins = array($this->login);
        $notice->Broadcast($this->hydna);
    }


    public function ProposeReplay()
    {
        $outRivalLogin = parent::ProposeReplay();

        $notice = new Notice('replay');
        $notice->SendTo($outRivalLogin, $this->hydna);

        return $outRivalLogin;
    }

    public function MakeMove($cell)
    {
        $states = parent::MakeMove($cell);
        list($state, $rivalState, $rivalLogin) = $states;

        $noticeMap = array(
            Entity\RoomState::STATE_WIN => 'win',
            Entity\RoomState::STATE_LOSS => 'loss',
            Entity\RoomState::STATE_DRAW => 'draw',
            Entity\RoomState::STATE_YOUR_MOVE => 'your_move',
            Entity\RoomState::STATE_RIVALS_MOVE => 'rivals_move');

        $notice = new Notice($noticeMap[$rivalState->code]);
        $notice->body->cell = $cell;
        $notice->body->cellToken = $state->token;
        $notice->body->state = $rivalState;

        $this->stopwatch->start('game:hydna:SendToUser');
        $notice->SendTo($rivalLogin, $this->hydna);
        $this->stopwatch->stop('game:hydna:SendToUser');

        return $states;
    }
} 