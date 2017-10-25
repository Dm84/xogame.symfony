<?php

namespace Xo\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation;

use Xo\GameBundle\View\XoView;
use Xo\GameBundle\Abstraction\IRenderer;

class LobbyController extends Controller implements IRenderer {
    use ControllerTrait;

    public function inviteAction($locale, HttpFoundation\Request $request)
    {
        $invitee = $request->get('invitee');
        $this->GetModel($locale, $request)->Invite($invitee);

        $response = new \stdClass();
        $response->type = 'invite';
        $response->body = new \stdClass();
        $response->body->invitee = $invitee;

        $model = $this->GetModel($locale, $request);
        $view = new XoView($model, $this);
        return $view->FormJsonResponse($response);
    }
    
    public function keepaliveAction($locale, HttpFoundation\Request $request)
    {        
        $model = $this->GetModel($locale, $request);
        $model->KeepAlive();
        $model->RemoveInactivePlayers();

        $view = new XoView($model, $this);
        return $view->FormJsonResponse('ok');
    }
    
    public function declineInviteAction($locale, HttpFoundation\Request $request)
    {
        $model = $this->GetModel($locale, $request);
        $model->Decline();

        $view = new XoView($model, $this);
        return $view->FormJsonResponse('ok');
    }
    
    public function cancelInviteAction($locale, HttpFoundation\Request $request)
    {
        $model = $this->GetModel($locale, $request);
        $model->Cancel();

        $view = new XoView($model, $this);
        return $view->FormJsonResponse('ok');
    }

    public function acceptInviteAction($locale, HttpFoundation\Request $request)
    {
        $model = $this->GetModel($locale, $request);
        $model->Accept();

        $view = new XoView($model, $this);
        return $view->RenderResponse($request);
    }
    
    public function quitLobbyAction($locale, HttpFoundation\Request $request) {
        
        $model = $this->GetModel($locale, $request);
        $model->LeaveLobby();

        $view = new XoView($model, $this);
        return $view->FormJsonResponse('ok');
    }    
}

