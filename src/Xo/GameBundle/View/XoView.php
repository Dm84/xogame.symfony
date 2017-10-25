<?php

namespace Xo\GameBundle\View;

use Symfony\Component\HttpFoundation;

use Xo\GameBundle\Model;
use Xo\GameBundle\Entity;
use Xo\GameBundle\Abstraction;

class SigninViewModel {

    /**
     * 
     * @var string
     */
    public $login;
    
    /**
     * 
     * @var Abstraction\ILanguage
     */
    public $lang;
    
    /**
     * 
     * @var string
     */
    public $signin_url;
    
    /**
     * 
     * @var string
     */
    public $signup_url;
    
    /**
     * 
     * @param string $login
     * @param \Xo\GameBundle\Abstraction\ILanguage $lang
     * @param string $signin_url
     * @param string $signup_url
     */
    public function __construct($login, Abstraction\ILanguage $lang, $signin_url, $signup_url) {
        $this->login = $login;
        $this->lang = $lang;
        $this->signin_url = $signin_url;
        $this->signup_url = $signup_url;
    }
}

class BoardViewModel {

    /**
     * @var array
     */
    public $board;
    
    /**
     *
     * @var boolean
     */
    public $can_move;
    
    /**
     *
     * @var boolean
     */
    public $can_replay;
    
    /**
     *
     * @var string
     */
    public $token;
    
    /**
     *
     * @var string
     */
    public $make_move_url;
    
    /**
     *
     * @var string
     */
    public $leave_url;
    
    /**
     *
     * @var string
     */
    public $quit_board_url;
    
    /**
     * @var string
     */
    public $replay_url;
    
    /**
     *
     * @var string
     */
    public $accept_replay_url;
    
    /**
     *
     * @var string
     */
    public $main_url;
    
    /**
     *
     * @var string
     */
    public $login;
    
    /**
     *
     * @var Abstraction\ILanguage
     */
    public $lang;
    
    /**
     * 
     * @param type $board
     * @param type $can_move
     * @param type $can_replay
     * @param type $token
     * @param type $make_move_url
     * @param type $leave_url
     * @param type $quit_board_url
     * @param type $replay_url
     * @param type $accept_replay_url
     * @param type $main_url
     * @param type $login
     * @param \Xo\GameBundle\Abstraction\ILanguage $lang
     */
    public function __construct(    
            $board, $can_move, $can_replay, $token, $make_move_url, $leave_url, 
            $quit_board_url, $replay_url, $accept_replay_url, $main_url, 
            $login, Abstraction\ILanguage $lang) 
    {
        $this->board = $board;
        $this->can_move = $can_move;
        $this->can_replay = $can_replay;
        $this->token = $token;
        $this->make_move_url = $make_move_url;
        $this->leave_url = $leave_url;
        $this->quit_board_url = $quit_board_url;
        $this->replay_url = $replay_url;
        $this->accept_replay_url = $accept_replay_url;
        $this->main_url = $main_url;
        $this->login = $login;
        $this->lang = $lang;
    }

}

class LobbyModelView {

    /**
     *
     * @var string
     */
    public $inviter;
    
    /**
     *
     * @var string
     */
    public $invitee;
    
    /**
     *
     * @var array
     */
    public $players;
    
    /**
     *
     * @var string
     */
    public $quit_url;
    
    /**
     *
     * @var string
     */
    public $main_url;
    
    /**
     *
     * @var string
     */
    public $keepalive_url;
    
    /**
     *
     * @var string
     */
    public $accept_url;
    
    /**
     *
     * @var string
     */
    public $invite_url;
    
    /**
     *
     * @var string
     */
    public $cancel_url;
    
    /**
     *
     * @var string
     */
    public $decline_url;
    
    /**
     *
     * @var string
     */
    public $login;
    
    /**
     *
     * @var Abstraction\ILanguage
     */
    public $lang;
    
    public function __construct($inviter, $invitee, $players, $quit_url, $main_url, $keepalive_url, 
            $accept_url, $invite_url, $cancel_url, $decline_url, $login, Abstraction\ILanguage $lang) 
    {
        $this->inviter = $inviter;
        $this->invitee = $invitee;
        $this->players = $players;
        $this->quit_url = $quit_url;
        $this->main_url = $main_url;
        $this->keepalive_url = $keepalive_url;
        $this->accept_url = $accept_url;
        $this->invite_url = $invite_url;
        $this->cancel_url = $cancel_url;
        $this->decline_url = $decline_url;
        $this->login = $login;
        $this->lang = $lang;
    }
}

class XoView implements Abstraction\IStateHandler {

    private $lang;
    private $login;
    private $locale;
    private $renderer;
    private $model;
    private $messages = array();
    private $cookies = array();

    public function __construct(Model\Game & $model, Abstraction\IRenderer & $renderer) {
        $this->model = $model;
        $this->lang = $model->lang;
        $this->renderer = $renderer;
        $this->locale = $model->locale;
        $this->login = $model->login;
    }

    public function HandleSignin()
    {
        $viewmodel = new SigninViewModel($this->login, $this->lang, 
                $this->renderer->MakeUrl('signin', array('locale' => $this->locale)),
                $this->renderer->MakeUrl('signup', array('locale' => $this->locale)));
        
        $body = $this->renderer->RenderTemplate('XoGameBundle:Views:signin.html.php', 
                array('model' => $viewmodel));

        return $body;
    }

    public function HandleBoard(Entity\RoomState $state) {

        $stateMessages = array (
            Entity\RoomState::STATE_WIN => $this->lang->BoardWin(),
            Entity\RoomState::STATE_LOSS => $this->lang->BoardLoss(),
            Entity\RoomState::STATE_DRAW => $this->lang->BoardDraw(),
            Entity\RoomState::STATE_RIVALS_MOVE => $this->lang->BoardRivalsMove(),
            Entity\RoomState::STATE_YOUR_MOVE => $this->lang->BoardYourMove()
        );

        $this->PostMessage('info', $stateMessages[$state->code]);
        
        $viewmodel = new BoardViewModel(
                $state->board, $state->canMove, $state->canReplay, $state->token,
                $this->renderer->MakeUrl('makemove', array('locale' => $this->locale)),
                $this->renderer->MakeUrl('quit_board', array('locale' => $this->locale)),
                $this->renderer->MakeUrl('replay', array('locale' => $this->locale)),
                $this->renderer->MakeUrl('accept_replay', array('locale' => $this->locale)),
                $this->renderer->MakeUrl('main', array('locale' => $this->locale)),
                $this->login, $this->lang);

        return $this->renderer->RenderTemplate('XoGameBundle:Views:board.html.php', array(
            'model' => $viewmodel));
    }

    private function FormLobbyBody($inviter = null, $invitee = null)
    {
        $this->model->KeepAlive();
        $this->model->RemoveInactivePlayers();

        $players = $this->model->GetLobbyPlayers();

        $viewmodel = new LobbyModelView($inviter, $invitee, $players, 
                $this->renderer->MakeUrl('quit_lobby', array('locale' => $this->locale)),
                $this->renderer->MakeUrl('main', array('locale' => $this->locale)),
                $this->renderer->MakeUrl('keepalive', array('locale' => $this->locale)),
                $this->renderer->MakeUrl('accept', array('locale' => $this->locale)),
                $this->renderer->MakeUrl('invite', array('locale' => $this->locale)),
                $this->renderer->MakeUrl('cancel', array('locale' => $this->locale)),
                $this->renderer->MakeUrl('decline', array('locale' => $this->locale)),
                $this->login,
                $this->lang);
        
        return $this->renderer->RenderTemplate('XoGameBundle:Views:lobby.html.php', 
                array('model' => $viewmodel));
    }

    public function HandleLobby()
    {
        return $this->FormLobbyBody();
    }

    public function HandleInvited($inviter) {

        return $this->FormLobbyBody($inviter);
    }

    public function HandleAwaiting($invitee) {

        return $this->FormLobbyBody(null, $invitee);
    }

    public function HandleLeft(Entity\RoomState $state) {

        $this->PostMessage('info', $this->lang->BoardLeft());
        return $this->HandleBoard($state);
    }

    public function SetCookies($login, $hash)
    {
        $this->cookies['login'] = $login;
        $this->cookies['hash'] = $hash;
    }

    private function InjectCookies(HttpFoundation\Response & $response)
    {
        foreach ($this->cookies as $name => $val)
        {
            $response->headers->setCookie(new HttpFoundation\Cookie($name, $val));
        }
    }

    public function FormJsonResponse($data = null)
    {
        $this->model->Flush();
        $obj = new \stdClass();
        $obj->messages = array_merge($this->messages, $this->model->messages);

        if ($data !== null) { $obj->response = $data; }

        $response = new HttpFoundation\JsonResponse($obj);
        $this->InjectCookies($response);
        return $response;
    }

    private function PostMessage($type, $body)
    {        
        $newMessage = new \stdClass();
        $newMessage->type = $type;
        $newMessage->body = $body;

        $this->messages[] = $newMessage;
    }

    public function RenderResponse(HttpFoundation\Request & $request)
    {
        $this->model->Flush();
        $body = $this->model->HandleState($this);
        $messagesArray = array_merge($this->messages, $this->model->messages);

        $response = null;

        if ($request->isXmlHttpRequest())
        {
            $data = new \stdClass();
            $data->html = $body;
            $data->messages = $messagesArray;
            $response = new HttpFoundation\JsonResponse($data);
        }
        else
        {
            $messages = $this->renderer->RenderTemplate('XoGameBundle:Views:messages.html.php', array(
                'messages' => $messagesArray));

            $navbar = $this->renderer->RenderTemplate('XoGameBundle:Views:navbar.html.php', array(
                'lang' => $this->lang,
                'login' => $this->model->login,
                'signout_url' => $this->renderer->MakeUrl('signout', array('locale' => $this->locale))));

            $response = new HttpFoundation\Response();
            $response->setContent($this->renderer->RenderTemplate('XoGameBundle:Views:layout.html.php', array(
                'messages' => $messages,
                'navbar' => $navbar,
                'content' => $body)));
        }

        $this->InjectCookies($response);
        return $response;
    }

} 