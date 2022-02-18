<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Enterprise\User;

use Depositphotos\SDK\Resource\Enterprise\User\Request\ChangeEmailRequest;
use Depositphotos\SDK\Resource\Enterprise\User\Request\ChangePasswordRequest;
use Depositphotos\SDK\Resource\Enterprise\User\Request\DeleteUserRequest;
use Depositphotos\SDK\Resource\Enterprise\User\Request\GetGroupRequest;
use Depositphotos\SDK\Resource\Enterprise\User\Request\GetStructureRequest;
use Depositphotos\SDK\Resource\Enterprise\User\Request\GetUserDataRequest;
use Depositphotos\SDK\Resource\Enterprise\User\Request\GetUsersFromGroupRequest;
use Depositphotos\SDK\Resource\Enterprise\User\Request\LoginRequest;
use Depositphotos\SDK\Resource\Enterprise\User\Request\LogoutRequest;
use Depositphotos\SDK\Resource\Enterprise\User\Request\MoveUserRequest;
use Depositphotos\SDK\Resource\Enterprise\User\Request\RegisterSubAccountRequest;
use Depositphotos\SDK\Resource\Enterprise\User\Request\RenewSessionRequest;
use Depositphotos\SDK\Resource\Enterprise\User\Request\SetPermissionsRequest;
use Depositphotos\SDK\Resource\Enterprise\User\Request\UpdateUserRequest;
use Depositphotos\SDK\Resource\Enterprise\User\Response\GetGroupResponse;
use Depositphotos\SDK\Resource\Enterprise\User\Response\GetStructureResponse;
use Depositphotos\SDK\Resource\Enterprise\User\Response\GetUserDataResponse;
use Depositphotos\SDK\Resource\Enterprise\User\Response\GetUsersFromGroupResponse;
use Depositphotos\SDK\Resource\Enterprise\User\Response\LoginResponse;
use Depositphotos\SDK\Resource\Enterprise\User\Response\RegisterSubAccountResponse;
use Depositphotos\SDK\Resource\Enterprise\User\Response\RenewSessionResponse;
use Depositphotos\SDK\Resource\Enterprise\User\Response\SetPermissionsResponse;
use Depositphotos\SDK\Resource\Enterprise\User\Response\UpdateUserResponse;
use Depositphotos\SDK\Resource\Resource;

class UserResource extends Resource
{
    public function login(LoginRequest $request): LoginResponse
    {
        $httpResponse = $this->send($request);

        return new LoginResponse($this->convertHttpResponseToArray($httpResponse));
    }

    public function logout(LogoutRequest $request): void
    {
        $this->send($request);
    }

    public function changeEmail(ChangeEmailRequest $request): void
    {
        $this->send($request);
    }

    public function changePassword(ChangePasswordRequest $request): void
    {
        $this->send($request);
    }

    public function getUserData(GetUserDataRequest $request): GetUserDataResponse
    {
        $httpResponse = $this->send($request);

        return new GetUserDataResponse($this->convertHttpResponseToArray($httpResponse)['data'] ?? []);
    }

    public function getUsersFromGroup(GetUsersFromGroupRequest $request): GetUsersFromGroupResponse
    {
        $httpResponse = $this->send($request);

        return new GetUsersFromGroupResponse($this->convertHttpResponseToArray($httpResponse));
    }

    public function renewSession(RenewSessionRequest $request): RenewSessionResponse
    {
        $httpResponse = $this->send($request);

        return new RenewSessionResponse($this->convertHttpResponseToArray($httpResponse)['data']);
    }

    public function setPermissions(SetPermissionsRequest $request): SetPermissionsResponse
    {
        $httpResponse = $this->send($request);

        return new SetPermissionsResponse($this->convertHttpResponseToArray($httpResponse));
    }

    public function updateUser(UpdateUserRequest $request): UpdateUserResponse
    {
        $httpResponse = $this->send($request);

        return new UpdateUserResponse($this->convertHttpResponseToArray($httpResponse));
    }

    public function deleteUser(DeleteUserRequest $request): void
    {
        $this->send($request);
    }

    public function moveUser(MoveUserRequest $request): void
    {
        $this->send($request);
    }

    public function registerSubAccount(RegisterSubAccountRequest $request): RegisterSubAccountResponse
    {
        $httpResponse = $this->send($request);

        return new RegisterSubAccountResponse($this->convertHttpResponseToArray($httpResponse));
    }

    public function getGroup(GetGroupRequest $request): GetGroupResponse
    {
        $httpResponse = $this->send($request);

        return new GetGroupResponse($this->convertHttpResponseToArray($httpResponse)['data'] ?? []);
    }

    public function getStructure(GetStructureRequest $request): GetStructureResponse
    {
        $httpResponse = $this->send($request);

        return new GetStructureResponse($this->convertHttpResponseToArray($httpResponse));
    }
}
