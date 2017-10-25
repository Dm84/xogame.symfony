<?php

namespace Xo\GameBundle\Model;

class RusLang implements \Xo\GameBundle\Abstraction\ILanguage {
    
    public function ErrorConnection() {
        return 'Ошибка соединения с сервером';
    }
    
    public function BoardReplayAcceptModalBody() {
        return 'Ожидание подтверждения';
    }
    
    public function BoardReplayAcceptModalHeader() {
        return 'Ожидание';
    }
    
    public function Signout() {
        return 'Выход';
    }
    
    public function BoardDraw() {
        return 'Ничья';
    }
    
    public function BoardLoss() {
        return 'Вы проиграли';
    }
    
    public function BoardRivalsMove() {
        return 'Ход противника';
    }
    
    public function BoardWin() {
        return 'Вы выиграли';
    }
    
    public function BoardYourMove() {
        return 'Ваш ход';
    }
    
    public function ErrorUnknown() {
        return 'Что-то пошло не так';
    }
    
    public function SignupSuccess() {
        return 'Вы успешно зарегистрированы';
    }


    public function ToInvite() {
        return 'Сыграть';
    }
    
    public function LobbyPlayersList() {
        return 'Игроки онлайн';
    }
    
    public function ErrorSignin() {
        return 'Ошибка авторизации: неверный логин или пароль';
    }

    public function ErrorSignup() {
        return 'Ошибка регистрации: неверный логин или пользователь с таким логином уже существует';
    }
    
    public function ErrorReplay() {
        return 'Невозможно переиграть партию';
    }
    
    public function BoardReplayModalBody() {
        return 'Оппонент предлагает матч-реванш)';
    }
    
    public function BoardReplayModalHeader() {
        return 'Матч-реванш';
    }
    
    public function Accept() {
        return 'Играть';
    }
    
    public function Cancel() {
        return 'Отменить';
    }
    
    public function Decline() {
        return 'Отклонить';
    }
    
    public function CancelNotify() {
        return 'Оппонент отменил приглашение';
    }

    public function DeclineNotify() {
        return 'Оппонент отклонил приглашение';
    }
    
    public function BoardLeft() {
        return 'Оппонент покинул игру';
    }
    
    public function BoardHeader() {
        return 'Доска';
    }
    
    public function BoardLeave() {
        return 'Выйти из игры';
    }
    
    public function BoardReplay() {
        return 'Переиграть';
    }
    
    public function AcceptAwaitingHeader() {
        return 'Подверждение';
    }
    
    public function AcceptAwaitingMessage() {
        return 'Ожидание подтверждения игроком';
    }
    
    public function ErrorAccept() {
        return 'Ошибка подтверждения';
    }
    
    public function ErrorDecline() {
        return 'Ошибка: не получилось отклонить приглашение';
    }
    
    public function ErrorInvite() {
        return 'Ошибка приглашения: возможно пользователь уже приглашен, либо в игре, либо не существует';
    }
    
    public function ErrorLogin() {
        return 'Неверное имя пользователя';
    }
    
    public function ErrorCancel() {
        return 'Ошибка при отмене приглашения';
    }
    
    public function ErrorMove() {
        return 'Невозможно совершить данный ход';
    }
    
    public function ErrorUser() {
        return 'Неверное имя пользователя';
    }
    
    public function InviteAcceptHeader() {
        return 'Приглашение в игру';
    }
    
    public function InviteAcceptMessage() {
        return 'Вы приглашены пользователем';
    }
    
    public function ErrorLeave() {
        return 'Ошибка: не получилось покинуть комнату';
    }
    
    public function Signup() { 
        return 'Зарегистрироваться';         
    }
    
    public function Signin() {
        return 'Войти';
    }
    
    public function SigninFormHeader() {
        return 'Вход';
    }
    
    public function SignupFormHeader() {
        return 'Регистрация';
    }
    
    public function FieldRequired()
    {
        return 'Обязательное поле';
    }
    
    public function LoginPlaceholder() {
        return 'Ваш логин';
    }
    
    public function PasswordPlaceholder() {
        return 'Ваш пароль';
    }

    
    public function PasswordPlaceholderConfirm() {
        return 'Ваш пароль еще раз';
    }
    
    public function PasswordConfirmRequirement() {
        return 'Пароли не совпадают';
    }
    
    public function PasswordLengthRequirement() {
        return 'Длина пароля должна быть не меньше (символов)';
    }
    
}