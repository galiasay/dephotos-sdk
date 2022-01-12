<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Tests\Resource\User;

use Depositphotos\SDK\Resource\Regular\User\Request\DTO\UserInfoDTO;
use Depositphotos\SDK\Resource\Regular\User\Request\LoginAsUserRequest;
use Depositphotos\SDK\Resource\Regular\User\Request\LoginByTokenRequest;
use Depositphotos\SDK\Resource\Regular\User\Request\LoginRequest;
use Depositphotos\SDK\Resource\Regular\User\Request\LogoutRequest;
use Depositphotos\SDK\Resource\Regular\User\Request\RecoverPasswordRequest;
use Depositphotos\SDK\Resource\Regular\User\Request\RegisterNewUserRequest;
use Depositphotos\SDK\Resource\Regular\User\Request\RenewSessionRequest;
use Depositphotos\SDK\Resource\Regular\User\UserResource;
use Depositphotos\SDK\Tests\BaseTestCase;
use Depositphotos\SDK\Tests\Resource\ResourceTrait;

class UserResourceTest extends BaseTestCase
{
    use ResourceTrait;

    public function testLogin(): void
    {
        $requestData = [
            'dp_command' => 'login',
            'dp_login_user' => 'username',
            'dp_login_password' => 'password',
        ];

        $responseData = [
            'type' => 'success',
            'sessionid' => 'e9753fbbd7454ea001b7619ce1e20fe5',
        ];

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->login(new LoginRequest(
            $requestData['dp_login_user'],
            $requestData['dp_login_password']
        ));

        $this->assertEquals($responseData['sessionid'], $result->getSessionId());
    }

    public function testLoginByToken(): void
    {
        $requestData = [
            'dp_command' => 'loginByToken',
            'dp_token' => '202cb962ac59075b964b07152d234b70',
        ];

        $responseData = [
            'type' => 'success',
            'sessionid' => 'e9753fbbd7454ea001b7619ce1e20fe5',
        ];

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->loginByToken(new LoginByTokenRequest($requestData['dp_token']));

        $this->assertEquals($responseData['sessionid'], $result->getSessionId());
    }

    public function testLoginAsUser(): void
    {
        $requestData = [
            'dp_command' => 'loginAsUser',
            'dp_login_user' => 'username',
            'dp_login_password' => 'password',
        ];

        $responseData = [
            'type' => 'success',
            'sessionid' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'session_cookie' => '2dccd1ab3e03990aea77359831c85ca2',
            'userid' => 123,
        ];

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->loginAsUser(new LoginAsUserRequest(
            $requestData['dp_login_user'],
            $requestData['dp_login_password']
        ));

        $this->assertEquals($responseData['sessionid'], $result->getSessionId());
        $this->assertEquals($responseData['session_cookie'], $result->getSessionCookie());
        $this->assertEquals($responseData['userid'], $result->getUserId());
    }

    public function testLogout(): void
    {
        $requestData = [
            'dp_command' => 'logout',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
        ];

        $responseData = [
            'type' => 'success',
        ];

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $resource->logout(new LogoutRequest($requestData['dp_session_id']));
    }

    public function testRecoverPassword(): void
    {
        $requestData = [
            'dp_command' => 'recoverPassword',
            'dp_login_user' => 'username',
            'dp_login_email' => 'username@mail.com',
        ];

        $responseData = [
            'type' => 'success',
        ];

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $resource->recoverPassword(new RecoverPasswordRequest(
            $requestData['dp_login_user'],
            $requestData['dp_login_email']
        ));
    }

    public function testRenewSession(): void
    {
        $requestData = [
            'dp_command' => 'renewSession',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
        ];

        $responseData = [
            'type' => 'success',
            'data' => [
                'sessionid' => '21d6f40cfb511982e4424e0e250a9557',
                'session_cookie' => '2dccd1ab3e03990aea77359831c85ca2',
                'userid' => 123,
            ],
        ];

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->renewSession(new RenewSessionRequest($requestData['dp_session_id']));

        $this->assertEquals($responseData['data']['sessionid'], $result->getSessionId());
        $this->assertEquals($responseData['data']['session_cookie'], $result->getSessionCookie());
        $this->assertEquals($responseData['data']['userid'], $result->getUserId());
    }

    public function testRegisterNewUser(): void
    {
        $requestData = [
            'dp_command' => 'registerNewUser',
            'dp_regist_user' => 'username',
            'dp_regist_email' => 'username@mail.com',
            'dp_regist_password' => 'password',
            'dp_user_info' => [
                'username' => 'username',
                'firstName' => 'firstName',
                'lastName' => 'lastname',
                'email' => 'test@mail.com',
                'country' => 'USA',
                'city' => 'New York',
                'state' => 'New York',
                'address' => 'test address',
                'zip' => '10001',
                'phone' => '+1 220-957-0553',
                'occupation' => null,
                'gender' => 'M',
                'company' => 'test company',
                'businessType' => null,
                'business' => null,
                'website' => null
            ],
        ];

        $responseData = [
            'type' => 'success',
            'userid' => 123,
        ];

        $userInfo = new UserInfoDTO();
        $userInfo
            ->setUsername($requestData['dp_user_info']['username'])
            ->setFirstName($requestData['dp_user_info']['firstName'])
            ->setLastName($requestData['dp_user_info']['lastName'])
            ->setEmail($requestData['dp_user_info']['email'])
            ->setCountry($requestData['dp_user_info']['country'])
            ->setCity($requestData['dp_user_info']['city'])
            ->setState($requestData['dp_user_info']['state'])
            ->setAddress($requestData['dp_user_info']['address'])
            ->setZip($requestData['dp_user_info']['zip'])
            ->setPhone($requestData['dp_user_info']['phone'])
            ->setOccupation($requestData['dp_user_info']['occupation'])
            ->setGender($requestData['dp_user_info']['gender'])
            ->setCompany($requestData['dp_user_info']['company'])
            ->setBusinessType($requestData['dp_user_info']['businessType'])
            ->setBusiness($requestData['dp_user_info']['business'])
            ->setWebsite($requestData['dp_user_info']['website']);


        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->registerNewUser(new RegisterNewUserRequest(
            $requestData['dp_regist_user'],
            $requestData['dp_regist_password'],
            $requestData['dp_regist_email'],
            $userInfo
        ));

        $this->assertEquals($responseData['userid'], $result->getUserId());
    }
}
