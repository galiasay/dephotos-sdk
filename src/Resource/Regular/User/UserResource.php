<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Regular\User;

use Depositphotos\SDK\Resource\Regular\User\Request\LoginAsUserRequest;
use Depositphotos\SDK\Resource\Regular\User\Request\LoginByTokenRequest;
use Depositphotos\SDK\Resource\Regular\User\Request\LoginRequest;
use Depositphotos\SDK\Resource\Regular\User\Request\LogoutRequest;
use Depositphotos\SDK\Resource\Regular\User\Request\RecoverPasswordRequest;
use Depositphotos\SDK\Resource\Regular\User\Request\RegisterNewUserRequest;
use Depositphotos\SDK\Resource\Regular\User\Request\RenewSessionRequest;
use Depositphotos\SDK\Resource\Regular\User\Response\LoginAsUserResponse;
use Depositphotos\SDK\Resource\Regular\User\Response\LoginByTokenResponse;
use Depositphotos\SDK\Resource\Regular\User\Response\LoginResponse;
use Depositphotos\SDK\Resource\Regular\User\Response\RegisterNewUserResponse;
use Depositphotos\SDK\Resource\Regular\User\Response\RenewSessionResponse;
use Depositphotos\SDK\Resource\Resource;

class UserResource extends Resource
{
    public function login(LoginRequest $request): LoginResponse
    {
        $httpResponse = $this->send($request);

        return LoginResponse::create($this->convertHttpResponseToArray($httpResponse));
    }

    public function loginByToken(LoginByTokenRequest $request): LoginByTokenResponse
    {
        $httpResponse = $this->send($request);

        return LoginByTokenResponse::create($this->convertHttpResponseToArray($httpResponse));
    }

    public function loginAsUser(LoginAsUserRequest $request): LoginAsUserResponse
    {
        $httpResponse = $this->send($request);

        return LoginAsUserResponse::create($this->convertHttpResponseToArray($httpResponse));
    }

    public function logout(LogoutRequest $request): void
    {
        $this->send($request);
    }

    public function recoverPassword(RecoverPasswordRequest $request): void
    {
        $this->send($request);
    }

    public function registerNewUser(RegisterNewUserRequest $request): RegisterNewUserResponse
    {
        $httpResponse = $this->send($request);

        return RegisterNewUserResponse::create($this->convertHttpResponseToArray($httpResponse));
    }

    public function renewSession(RenewSessionRequest $request): RenewSessionResponse
    {
        $httpResponse = $this->send($request);

        return RenewSessionResponse::create($this->convertHttpResponseToArray($httpResponse));
    }
}
