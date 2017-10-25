<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Xo\GameBundle\Abstraction;

interface ILanguage {
    
    public function LoginPlaceholder();
    public function PasswordPlaceholder();
    public function PasswordPlaceholderConfirm();
    
    public function Signin();
    public function Signup();
    public function Signout();
    
    public function SignupSuccess();
    
    public function PasswordLengthRequirement();
    public function PasswordConfirmRequirement();
    
    public function SigninFormHeader();
    public function SignupFormHeader();
    
    public function FieldRequired();
    
    public function BoardHeader();
    public function BoardReplay();
    public function BoardLeave();
    public function BoardLeft();
    public function BoardDraw();
    public function BoardWin();
    public function BoardLoss();
    public function BoardYourMove();
    public function BoardRivalsMove();
    public function BoardReplayModalHeader();
    public function BoardReplayModalBody();
    public function BoardReplayAcceptModalHeader();
    public function BoardReplayAcceptModalBody();

    
    public function LobbyPlayersList();
    public function ToInvite();
    public function Cancel();
    public function Accept();
    public function Decline();
    
    public function CancelNotify();
    public function DeclineNotify();
    
    public function InviteAcceptHeader();
    public function InviteAcceptMessage();
    public function AcceptAwaitingHeader();
    public function AcceptAwaitingMessage();    

    public function ErrorConnection();
    public function ErrorReplay();    
    public function ErrorLogin();
    public function ErrorUser();
    public function ErrorUnknown();
    public function ErrorSignin();
    public function ErrorSignup();
    public function ErrorInvite();
    public function ErrorMove();
    public function ErrorAccept();
    public function ErrorDecline();
    public function ErrorLeave();
    public function ErrorCancel();
}