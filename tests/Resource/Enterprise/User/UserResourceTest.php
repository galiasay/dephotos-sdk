<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Tests\Resource\Enterprise\User;

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
use Depositphotos\SDK\Resource\Enterprise\User\Response\Common\User;
use Depositphotos\SDK\Resource\Enterprise\User\UserResource;
use Depositphotos\SDK\Tests\BaseTestCase;
use Depositphotos\SDK\Tests\Resource\ResourceTrait;

class UserResourceTest extends BaseTestCase
{
    use ResourceTrait;

    public function testLogin(): void
    {
        $requestData = [
            'dp_command' => 'loginEnterprise',
            'dp_login_user' => 'username',
            'dp_login_password' => 'password',
        ];

        $responseData = [
            'type' => 'success',
            'sessionid' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'userid' => 123,
        ];

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->login(new LoginRequest(
            $requestData['dp_login_user'],
            $requestData['dp_login_password']
        ));

        $this->assertEquals($responseData['sessionid'], $result->getSessionId());
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

    public function testChangeEmail(): void
    {
        $requestData = [
            'dp_command' => 'changeEmail',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_email' => 'newemail@mail'
        ];

        $responseData = [
            'type' => 'success',
        ];

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $resource->changeEmail(new ChangeEmailRequest(
            $requestData['dp_session_id'],
            $requestData['dp_email']
        ));
    }

    public function testChangePassword(): void
    {
        $requestData = [
            'dp_command' => 'changePasswordEnterpriseUserByAdmin',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_user_id' => 123,
            'dp_new_password' => 'new_password'
        ];

        $responseData = [
            'type' => 'success',
        ];

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $resource->changePassword(new ChangePasswordRequest(
            $requestData['dp_session_id'],
            $requestData['dp_user_id'],
            $requestData['dp_new_password']
        ));
    }

    public function testGetEnterpriseUserData(): void
    {
        $requestData = [
            'dp_command' => 'getEnterpriseUserData',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
        ];

        $responseData = [
            'type' => 'success',
            'data' => [
                'username' => 'tester',
                'firstName' => 'Dthtfh',
                'lastName' => 'DFHNY',
                'city' => '',
                'avatarBig' => null,
                'avatarSmall' => null,
                'occupation' => null,
                'avatar' => null,
                'userId' => 112488877,
                'address' => '',
                'email' => 'email@mail',
                'phone' => null,
                'state' => null,
                'zip' => null,
                'registered' => 1579018896,
                'enterpriseLite' => [
                    'groupId' => 9309784
                ],
                'country' => 'UA',
                'businessName' => null,
                'timezone' => 'Europe/Berlin',
                'website' => '',
                'industry' => null,
                'biography' => null,
                'vatNumber' => null,
            ]
        ];

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getUserData(new GetUserDataRequest($requestData['dp_session_id']));

        $this->assertUser($responseData['data'], $result);
        $this->assertEquals($responseData['data']['country'], $result->getCountry());
        $this->assertEquals($responseData['data']['businessName'], $result->getBusinessName());
        $this->assertEquals($responseData['data']['timezone'], $result->getTimezone());
        $this->assertEquals($responseData['data']['website'], $result->getWebsite());
        $this->assertEquals($responseData['data']['industry'], $result->getIndustry());
        $this->assertEquals($responseData['data']['biography'], $result->getBiography());
        $this->assertEquals($responseData['data']['vatNumber'], $result->getVatNumber());
    }

    public function testGetUsersFromGroup(): void
    {
        $requestData = [
            'dp_command' => 'getUsersFromGroup',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_limit' => 10,
            'dp_offset' => 0,
            'dp_date_start' =>'2022-01-03 00:00:00',
            'dp_date_end' => null,
            'dp_all_structure' => false,
            'dp_user_id' => [],
        ];

        $responseData = [
            'type' => 'success',
            'data' => [
                [
                    'username' => 'tester',
                    'firstName' => 'Firstname',
                    'lastName' => 'Lastname',
                    'city' => '',
                    'avatarBig' => null,
                    'avatarSmall' => null,
                    'occupation' => null,
                    'avatar' => null,
                    'userId' => 112488877,
                    'address' => 'dhfyj',
                    'email' => 'email@mail',
                    'phone' => null,
                    'state' => null,
                    'zip' => null,
                    'registered' => 1579018896,
                    'enterpriseLite' => [
                        'groupId' => 9309784,
                    ],
                    'enterpriseStats' => [
                        'comps' => 0,
                        'licensed' => '19998',
                        'transferred' => 0,
                    ],
                    'permissions' => [
                        [
                            'resourceType' => 'enterprise',
                            'action' => 'login',
                        ],
                        [
                            'resourceType' => 'enterprise',
                            'action' => 'license',
                        ],
                        [
                            'resourceType' => 'enterprise',
                            'action' => 'compDownloads',
                        ],
                        [
                            'resourceType' => 'enterprise_group',
                            'resourceId' => 9309784,
                            'action' => 'edit',
                        ],
                    ],
                ],
            ],
            'count' => 123,
        ];

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getUsersFromGroup(new GetUsersFromGroupRequest(
            $requestData['dp_session_id'],
            $requestData['dp_limit'],
            $requestData['dp_offset'],
            new \DateTime($requestData['dp_date_start']),
            $requestData['dp_date_end'],
            $requestData['dp_all_structure'],
            $requestData['dp_user_id']
        ));

        foreach ($result->getUsers() as $key => $user) {
            $this->assertUser($responseData['data'][$key], $user);
            $this->assertEquals($responseData['data'][$key]['enterpriseStats']['comps'], $user->getStats()->getComps());
            $this->assertEquals($responseData['data'][$key]['enterpriseStats']['licensed'], $user->getStats()->getLicensed());
            $this->assertEquals($responseData['data'][$key]['enterpriseStats']['transferred'], $user->getStats()->getTransferred());
        }
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
                'userid' => 123,
            ],
        ];

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->renewSession(new RenewSessionRequest($requestData['dp_session_id']));

        $this->assertEquals($responseData['data']['sessionid'], $result->getSessionId());
        $this->assertEquals($responseData['data']['userid'], $result->getUserId());
    }

    public function testSetPermissions(): void
    {
        $requestData = [
            'dp_command' => 'setEnterprisePermissions',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_user_id' => 123,
            'dp_permission' => 'license',
            'dp_state' => true,
        ];

        $responseData = [
            'type' => 'success',
            'permissions' => [
                'enterprise:12345' => [
                    'license',
                ],
            ],
        ];

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->setPermissions(new SetPermissionsRequest(
            $requestData['dp_session_id'],
            $requestData['dp_user_id'],
            $requestData['dp_permission'],
            $requestData['dp_state']
        ));


        foreach ($result->getPermissions() as $permission) {
            $key = implode(':', [$permission->getResourceName(), $permission->getResourceId()]);
            $this->assertEquals($responseData['permissions'][$key], $permission->getActions());
        }
    }

    public function testUpdateUser(): void
    {
        $requestData = [
            'dp_command' => 'updateEnterpriseUser',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_user_id' => 123,
            'dp_email' => 'email@test',
            'dp_first_name' => 'Firstname',
            'dp_last_name' => 'Lastname',
            'dp_country' => 'Ukraine',
            'dp_city' => 'Kiev',
            'dp_state' => null,
            'dp_address' => null,
            'dp_zip' => null,
            'dp_phone' => null,
            'dp_occupation' => null,
        ];

        $responseData = [
            'type' => 'success',
            'username' => 'tester',
            'firstName' => 'Dthtfh',
            'lastName' => 'DFHNY',
            'city' => '',
            'avatarBig' => null,
            'avatarSmall' => null,
            'occupation' => null,
            'avatar' => null,
            'userId' => 112488877,
            'address' => '',
            'email' => 'email@mail',
            'phone' => null,
            'state' => null,
            'zip' => null,
            'registered' => 1579018896,
            'enterpriseLite' => [
                'groupId' => 9309784
            ],
            'country' => 'UA',
            'businessName' => null,
            'timezone' => 'Europe/Berlin',
            'website' => '',
            'industry' => null,
            'biography' => null,
            'vatNumber' => null,
            'enterpriseEnabled' => true,
            'enterpriseStats' => [
                'comps' => 0,
                'licensed' => '19998',
                'transferred' => 0,
            ],
        ];

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $request = new UpdateUserRequest(
            $requestData['dp_session_id'],
            $requestData['dp_user_id'],
            $requestData['dp_email']
        );
        $request
            ->setFirstName($requestData['dp_first_name'])
            ->setLastName($requestData['dp_last_name'])
            ->setCountry($requestData['dp_country'])
            ->setCity($requestData['dp_city']);
        $result = $resource->updateUser($request);

        $this->assertUser($responseData, $result);
        $this->assertEquals($responseData['enterpriseEnabled'], $result->isEnabled());
        $this->assertEquals($responseData['enterpriseStats']['comps'], $result->getStats()->getComps());
        $this->assertEquals($responseData['enterpriseStats']['licensed'], $result->getStats()->getLicensed());
        $this->assertEquals($responseData['enterpriseStats']['transferred'], $result->getStats()->getTransferred());
    }

    public function testDeleteUser(): void
    {
        $requestData = [
            'dp_command' => 'deleteEnterpriseUser',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_user_id' => 123,
        ];

        $responseData = [
            'type' => 'success',
        ];

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $resource->deleteUser(new DeleteUserRequest(
            $requestData['dp_session_id'],
            $requestData['dp_user_id']
        ));
    }

    public function testMoveUser(): void
    {
        $requestData = [
            'dp_command' => 'moveEnterpriseUser',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_user_id' => 123,
            'dp_group_id' => 123,
        ];

        $responseData = [
            'type' => 'success',
        ];

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $resource->moveUser(new MoveUserRequest(
            $requestData['dp_session_id'],
            $requestData['dp_user_id'],
            $requestData['dp_group_id']
        ));
    }

    public function testRegisterSubAccount(): void
    {
        $requestData = [
            'dp_command' => 'registerEnterpriseSubaccount',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_regist_user' => 'username',
            'dp_regist_email' => 'email@test',
            'dp_regist_password' => 'password',
            'dp_group_id' => null,
            'dp_user_info' => [
                'firstName' => 'Firstname',
                'lastName' => 'LastName',
                'phone' => null,
                'occupation' => null,
            ],
        ];

        $responseData = [
            'type' => 'success',
            'userid' => 123,
        ];

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $request = new RegisterSubAccountRequest(
            $requestData['dp_session_id'],
            $requestData['dp_regist_user'],
            $requestData['dp_regist_email'],
            $requestData['dp_regist_password']
        );
        $request
            ->setFirstName($requestData['dp_user_info']['firstName'])
            ->setLastName($requestData['dp_user_info']['lastName']);
        $result = $resource->registerSubAccount($request);

        $this->assertEquals($responseData['userid'], $result->getUserId());
    }

    public function testGetGroup(): void
    {
        $requestData = [
            'dp_command' => 'getUserEnterpriseGroup',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
        ];

        $responseData = [
            'type' => 'success',
            'data' => [
                'groupId' => 123,
                'profileId' => 111,
                'money' => 12345.12,
                'vatNumber' => 'AX-1234',
                'vatRate' => 5.5,
                'vatEnabled' => true,
                'isPostpayment' => true,
                'balance' => 12345.12,
            ],
        ];

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getGroup(new GetGroupRequest($requestData['dp_session_id']));

        $this->assertEquals($responseData['data']['groupId'], $result->getGroupId());
        $this->assertEquals($responseData['data']['profileId'], $result->getProfileId());
        $this->assertEquals($responseData['data']['money'], $result->getMoney());
        $this->assertEquals($responseData['data']['vatNumber'], $result->getVatNumber());
        $this->assertEquals($responseData['data']['vatRate'], $result->getVatRate());
        $this->assertEquals($responseData['data']['vatEnabled'], $result->isVatEnabled());
        $this->assertEquals($responseData['data']['isPostpayment'], $result->isPostPayment());
        $this->assertEquals($responseData['data']['balance'], $result->getBalance());
    }

    public function testGetStructure(): void
    {
        $requestData = [
            'dp_command' => 'getUserEnterpriseStructure',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_all_structure' => false
        ];

        $responseData = [
            'type' => 'success',
            'data' => [
                [
                    'id' => 3,
                    'status' => 'enabled',
                    'name' => 'Group name',
                    'overdraft' =>  100000,
                ],
            ],
            'count' => 1,
        ];

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getStructure(new GetStructureRequest($requestData['dp_session_id']));

        $this->assertEquals($responseData['count'], $result->getCount());
        foreach ($result->getGroups() as $key => $group) {
            $this->assertEquals($responseData['data'][$key]['id'], $group->getId());
            $this->assertEquals($responseData['data'][$key]['status'], $group->getStatus());
            $this->assertEquals($responseData['data'][$key]['name'], $group->getName());
            $this->assertEquals($responseData['data'][$key]['overdraft'], $group->getOverdraft());
        }
    }

    private function assertUser(array $expected, User $user): void
    {
        $this->assertEquals($expected['username'], $user->getUsername());
        $this->assertEquals($expected['firstName'], $user->getFirstName());
        $this->assertEquals($expected['lastName'], $user->getLastName());
        $this->assertEquals($expected['city'], $user->getCity());
        $this->assertEquals($expected['avatarBig'], $user->getAvatarBig());
        $this->assertEquals($expected['avatarSmall'], $user->getAvatarSmall());
        $this->assertEquals($expected['occupation'], $user->getOccupation());
        $this->assertEquals($expected['avatar'], $user->getAvatar());
        $this->assertEquals($expected['userId'], $user->getId());
        $this->assertEquals($expected['address'], $user->getAddress());
        $this->assertEquals($expected['email'], $user->getEmail());
        $this->assertEquals($expected['phone'], $user->getPhone());
        $this->assertEquals($expected['state'], $user->getState());
        $this->assertEquals($expected['zip'], $user->getZip());
        $this->assertEquals($expected['registered'], $user->getRegistered()->getTimestamp());
        $this->assertEquals($expected['enterpriseLite'], $user->getEnterpriseLite());
    }
}
