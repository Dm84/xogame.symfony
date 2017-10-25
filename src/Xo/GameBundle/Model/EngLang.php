<?php

namespace Xo\GameBundle\Model;

class EngLang implements \Xo\GameBundle\Abstraction\ILanguage {
    
    public function ErrorConnection() {
        return 'Connection error';
    }    
    
    public function BoardReplayAcceptModalBody() {
        return 'Awaiting accept';
    }    
    
    public function BoardReplayAcceptModalHeader() {
        return 'Awaiting';
    }
    
    public function Signout() {
        return 'Sign out';
    }
    
    public function BoardDraw() {
        return 'Draw';
    }
    
    public function BoardLoss() {
        return 'Loss';
    }
    
    public function BoardRivalsMove() {
        return 'Rivals move';
    }
    
    public function BoardWin() {
        return 'Win';
    }
    
    public function BoardYourMove() {
        return 'Your move';
    }
    
    public function ErrorUnknown() {
        return 'Something goes wrong';
    }
    
    public function SignupSuccess() {
        return 'Sign up is successful';
    }


    public function ToInvite() {
        return 'Play';
    }
    
    public function LobbyPlayersList() {
        return 'Online players';
    }
    
    public function ErrorSignin() {
        return 'Sign in error: incorrect login or password';
    }

    public function ErrorSignup() {
        return 'Sign up error: incorrect login';
    }
    
    public function ErrorReplay() {
        return 'Cannot replay';
    }
    
    public function BoardReplayModalBody() {
        return 'Rival proposes replay';
    }
    
    public function BoardReplayModalHeader() {
        return 'Replay';
    }
    
    public function Accept() {
        return 'Play';
    }
    
    public function Cancel() {
        return 'Cancel';
    }
    
    public function Decline() {
        return 'Decline';
    }
    
    public function CancelNotify() {
        return 'Rival has canceled invite';
    }

    public function DeclineNotify() {
        return 'Rival has declined your invite';
    }
    
    public function BoardLeft() {
        return 'Rival had left the game';
    }
    
    public function BoardHeader() {
        return 'Board';
    }
    
    public function BoardLeave() {
        return 'Leave';
    }
    
    public function BoardReplay() {
        return 'Replay';
    }
    
    public function AcceptAwaitingHeader() {
        return 'Accept';
    }
    
    public function AcceptAwaitingMessage() {
        return 'Awaiting acceptance';
    }
    
    public function ErrorAccept() {
        return 'Accept error';
    }
    
    public function ErrorDecline() {
        return 'Decline error';
    }
    
    public function ErrorInvite() {
        return 'Invite error: user is invited already or playing';
    }
    
    public function ErrorLogin() {
        return 'Incorrect login';
    }
    
    public function ErrorCancel() {
        return 'Cancel error';
    }
    
    public function ErrorMove() {
        return 'Move error';
    }
    
    public function ErrorUser() {
        return 'Incorrect login';
    }
    
    public function InviteAcceptHeader() {
        return 'Invite';
    }
    
    public function InviteAcceptMessage() {
        return 'You are invited';
    }
    
    public function ErrorLeave() {
        return 'Leave error';
    }
    
    public function Signup() { 
        return 'Sign up';         
    }
    
    public function Signin() {
        return 'Sign in';
    }
    
    public function SigninFormHeader() {
        return 'Sign in';
    }
    
    public function SignupFormHeader() {
        return 'Sign up';
    }
    
    public function FieldRequired()
    {
        return 'Required field';
    }
    
    public function LoginPlaceholder() {
        return 'Your login';
    }
    
    public function PasswordPlaceholder() {
        return 'Your pass';
    }

    
    public function PasswordPlaceholderConfirm() {
        return 'Your pass again';
    }
    
    public function PasswordConfirmRequirement() {
        return 'Passwords should match';
    }
    
    public function PasswordLengthRequirement() {
        return 'Длина пароля должна быть не меньше (символов)';
    }
    
}