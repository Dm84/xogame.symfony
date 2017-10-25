<?php

namespace Xo\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation;

use Xo\GameBundle\Entity;
use Xo\GameBundle\View\XoView;
use Xo\GameBundle\Abstraction\IRenderer;

class BoardController extends Controller implements IRenderer {
    use ControllerTrait;

    public function makemoveAction($locale, HttpFoundation\Request $request)
    {
        $stopwatch = $this->GetStopwatch();
        $stopwatch->start('makemove');

        $cell = intval($request->get('cell'));
        list($state, $rivalState, $rivalLogin) = $this->GetModel($locale, $request)->MakeMove($cell);
        
        $noticeMap = array( 
            Entity\RoomState::STATE_WIN => 'win',
            Entity\RoomState::STATE_LOSS => 'loss',
            Entity\RoomState::STATE_DRAW => 'draw',
            Entity\RoomState::STATE_YOUR_MOVE => 'your_move',
            Entity\RoomState::STATE_RIVALS_MOVE => 'rivals_move');

        $response = new \stdClass();
        $response->type = $noticeMap[$state->code];
        $response->body = new \stdClass();
        $response->body->cell = $cell;
        $response->body->cellToken = $state->token;
        $response->body->state = $state;

        $stopwatch->stop('makemove');

        $model = $this->GetModel($locale, $request);
        $view = new XoView($model, $this);
        return $view->FormJsonResponse($response);
    }

    public function proposeReplayAction($locale, HttpFoundation\Request $request)
    {
        $model = $this->GetModel($locale, $request);
        $model->ProposeReplay();

        $view = new XoView($model, $this);
        return $view->FormJsonResponse('ok');
    }

    public function acceptReplayAction($locale, HttpFoundation\Request $request)
    {
        $model = $this->GetModel($locale, $request);
        $model->Replay();

        $view = new XoView($model, $this);
        return $view->RenderResponse($request);
    }    

    public function leaveRoomAction($locale, HttpFoundation\Request $request)
    {
        $model = $this->GetModel($locale, $request);
        $model->LeaveRoomIfPlaying();

        $view = new XoView($model, $this);
        return $view->RenderResponse($request);
    }
    
    
    public function quitBoardAction($locale, HttpFoundation\Request $request) {
        
        $model = $this->GetModel($locale, $request);
        $model->LeaveRoomIfPlaying();
        $model->LeaveLobby();

        $view = new XoView($model, $this);
        return $view->FormJsonResponse('ok');
    }
}

