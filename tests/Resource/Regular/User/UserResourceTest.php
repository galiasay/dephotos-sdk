<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Tests\Resource\Regular\User;

use Depositphotos\SDK\Resource\Regular\User\Request\AvailableFundsRequest;
use Depositphotos\SDK\Resource\Regular\User\Request\ChangePasswordRequest;
use Depositphotos\SDK\Resource\Regular\User\Request\DTO\UserInfoDTO;
use Depositphotos\SDK\Resource\Regular\User\Request\GetIndustryListRequest;
use Depositphotos\SDK\Resource\Regular\User\Request\GetUserDataRequest;
use Depositphotos\SDK\Resource\Regular\User\Request\GetUserSearchHintsRequest;
use Depositphotos\SDK\Resource\Regular\User\Request\LoginAsUserRequest;
use Depositphotos\SDK\Resource\Regular\User\Request\LoginByTokenRequest;
use Depositphotos\SDK\Resource\Regular\User\Request\LoginRequest;
use Depositphotos\SDK\Resource\Regular\User\Request\LogoutRequest;
use Depositphotos\SDK\Resource\Regular\User\Request\RecoverPasswordRequest;
use Depositphotos\SDK\Resource\Regular\User\Request\RegisterNewUserRequest;
use Depositphotos\SDK\Resource\Regular\User\Request\RenewSessionRequest;
use Depositphotos\SDK\Resource\Regular\User\Request\UpdateUserRequest;
use Depositphotos\SDK\Resource\Regular\User\UserResource;
use Depositphotos\SDK\Tests\BaseTestCase;
use Depositphotos\SDK\Tests\Resource\ResourceTrait;

class UserResourceTest extends BaseTestCase
{
    use ResourceTrait;

    private const DATE_FORMAT = 'M.d, Y H:i:s';

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
            'userid' => 123,
        ];

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->loginAsUser(new LoginAsUserRequest(
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
                'userid' => 123,
            ],
        ];

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->renewSession(new RenewSessionRequest($requestData['dp_session_id']));

        $this->assertEquals($responseData['data']['sessionid'], $result->getSessionId());
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

    public function testChangePassword(): void
    {
        $requestData = [
            'dp_command' => 'changePassword',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_old_password' => 'old-password',
            'dp_new_password' => 'new-password',
        ];

        $responseData = [
            'type' => 'success',
        ];

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $resource->changePassword(new ChangePasswordRequest(
            $requestData['dp_session_id'],
            $requestData['dp_old_password'],
            $requestData['dp_new_password']
        ));
    }

    public function testGetIndustryList(): void
    {
        $requestData = [
            'dp_command' => 'getIndustryList',
        ];

        $responseData = [
            'type' => 'success',
            'industries' => [
                'Business Services',
                'Commercial Production',
                'Consumer Packaged Goods',
                'Culture',
            ],
        ];

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getIndustryList(new GetIndustryListRequest());

        $this->assertEquals($responseData['industries'], $result->getIndustries());
    }

    public function testGetUserSearchHints(): void
    {
        $requestData = [
            'dp_command' => 'getUserSearchHint',
            'dp_prefix' => 'prefix',
            'dp_count' => 10,
        ];

        $responseData = [
            'type' => 'success',
            'hints' => [
                [
                    'avatar' => 'https://static.depositphotos.com/storage/avatars/1192/1192060/a_1192060.jpg?e1542fa35b653589c38445d92809fdef',
                    'onlinePhotos' => '213021',
                    'onlineFiles' => '213021',
                    'sellerId' => 1192060,
                    'phraseMatched' => 'pho',
                    'phraseSuggestion' => 'tography33',
                    'phrase' => 'photography33',
                    'sellerInfo' => 'Angel Nieto',
                    'sellerUrl' => '/portfolio-1192060.html',
                ],
                [
                    'avatar' => 'https://static.depositphotos.com/storage/avatars/2249/2249091/a_2249091.jpg?a2eac52a7067b7f34911377573feae7a',
                    'onlinePhotos' => '111591',
                    'onlineFiles' => '111591',
                    'sellerId' => 2249091,
                    'phraseMatched' => 'pho',
                    'phraseSuggestion' => 'tographee.eu',
                    'phrase' => 'photographee.eu',
                    'sellerInfo' => 'Katarzyna Białasiewicz',
                    'sellerUrl' => '/portfolio-2249091.html',
                ],
            ],
        ];

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getUserSearchHints(new GetUserSearchHintsRequest(
            $requestData['dp_prefix'],
            $requestData['dp_count']
        ));

        $this->assertCount(count($responseData['hints']), $result->getHints());

        foreach ($result->getHints() as $key => $hint) {
            $this->assertEquals($responseData['hints'][$key], [
                'avatar' => $hint->getAvatar(),
                'onlinePhotos' => $hint->getOnlinePhotos(),
                'onlineFiles' => $hint->getOnlineFiles(),
                'sellerId' => $hint->getSellerId(),
                'phraseMatched' => $hint->getPhraseMatched(),
                'phraseSuggestion' => $hint->getPhraseSuggestion(),
                'phrase' => $hint->getPhrase(),
                'sellerInfo' => $hint->getSellerInfo(),
                'sellerUrl' => $hint->getSellerUrl(),
            ]);
        }
    }

    public function testAvailableFunds(): void
    {
        $requestData = [
            'dp_command' => 'availableFunds',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_datetime_format' => 'datetime',
        ];

        $responseData = [
            'type' => 'success',
            'balance' => 42.81,
            'creditsAvailable' => 7.5,
            'creditsExpire' => 'Aug.18, 2015 05:17:31',
            'subscriptionDownloadsTodayAvailable' => 12,
            'leftBonusFiles' => 3,
            'activeSubscriptions' => [
                [
                    'id' => '7928098',
                    'name' => 'Promo Subscription',
                    'status' => 'active',
                    'purchaseMethod' => 'promocode',
                    'dateBegin' => 'Sep.02, 2014 13:15:00',
                    'dateEnd' => 'Sep.17, 2015 13:15:00',
                    'amount' => '5',
                    'count' => 3,
                    'period' => '365',
                    'buyPeriod' => 1,
                    'renewalTime' => 'Sep.17, 2015 13:15:00',
                ]
            ],
            'onDemandDownloads' => [
                [
                    'balance' => '4',
                    'product' => 'image',
                    'subproduct' => 'standart',
                    'expire' => 'Feb.24, 2017 14:09:50',
                ]
            ],
        ];

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->availableFunds(new AvailableFundsRequest(
            $requestData['dp_session_id'],
            $requestData['dp_datetime_format']
        ));

        $this->assertEquals($responseData['balance'], $result->getBalance());
        $this->assertEquals($responseData['creditsAvailable'], $result->getCreditsAvailable());
        $this->assertEquals($responseData['creditsExpire'], $result->getCreditsExpire());
        $this->assertEquals($responseData['subscriptionDownloadsTodayAvailable'], $result->getSubscriptionDownloadsTodayAvailable());
        $this->assertEquals($responseData['leftBonusFiles'], $result->getLeftBonusFiles());
        $this->assertCount(count($responseData['activeSubscriptions']), $result->getSubscriptions());
        $this->assertCount(count($responseData['onDemandDownloads']), $result->getOnDemands());

        foreach ($result->getSubscriptions() as $key => $subscription) {
            $this->assertEquals($responseData['activeSubscriptions'][$key], [
                'id' => $subscription->getId(),
                'name' => $subscription->getName(),
                'status' => $subscription->getStatus(),
                'purchaseMethod' => $subscription->getPurchaseMethod(),
                'dateBegin' => $subscription->getBeginDate()->format(self::DATE_FORMAT),
                'dateEnd' => $subscription->getEndDate()->format(self::DATE_FORMAT),
                'amount' => $subscription->getAmount(),
                'period' => $subscription->getPeriod(),
                'buyPeriod' => $subscription->getBuyPeriod(),
                'renewalTime' => $subscription->getRenewalTime()->format(self::DATE_FORMAT),
                'count' => $subscription->getBalance(),
            ]);
        }

        foreach ($result->getOnDemands() as $key => $onDemand) {
            $this->assertEquals($responseData['onDemandDownloads'][$key], [
                'balance' => $onDemand->getBalance(),
                'product' => $onDemand->getProduct(),
                'subproduct' => $onDemand->getSubProduct(),
                'expire' => $onDemand->getExpire()->format(self::DATE_FORMAT),
            ]);
        }
    }

    public function testUpdateUser(): void
    {
        $requestData = [
            'dp_command' => 'updateUser',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_email' => 'email@test.com',
            'dp_first_name' => 'Test',
            'dp_last_name' => 'Test',
            'dp_username' => 'testuser',
            'dp_gender' => 'male',
            'dp_address' => '',
            'dp_city' => 'NY',
            'dp_state' => 'NY',
            'dp_country' => 'USA',
            'dp_zip' => '',
            'dp_timezone' => 'America/New_York',
            'dp_phone' => '',
            'dp_news' => 'no',
            'dp_company' => 'Company',
            'dp_business_name' => 'Company',
            'dp_business_phone' => '',
            'dp_website' => null,
            'dp_facebook' => null,
            'dp_occupation' => '',
            'dp_biography' => '',
            'dp_industry' => '',
        ];

        $responseData = [
            'type' => 'success',
        ];

        $request = new UpdateUserRequest($requestData['dp_session_id']);
        $request->setEmail($requestData['dp_email']);
        $request->setFirstName($requestData['dp_first_name']);
        $request->setLastName($requestData['dp_last_name']);
        $request->setUsername($requestData['dp_username']);
        $request->setGender($requestData['dp_gender']);
        $request->setAddress($requestData['dp_address']);
        $request->setCity($requestData['dp_city']);
        $request->setState($requestData['dp_state']);
        $request->setCountry($requestData['dp_country']);
        $request->setZip($requestData['dp_zip']);
        $request->setTimezone($requestData['dp_timezone']);
        $request->setPhone($requestData['dp_phone']);
        $request->setNews($requestData['dp_news']);
        $request->setCompany($requestData['dp_company']);
        $request->setBusinessName($requestData['dp_business_name']);
        $request->setBusinessPhone($requestData['dp_business_phone']);
        $request->setWebsite($requestData['dp_website']);
        $request->setFacebook($requestData['dp_facebook']);
        $request->setOccupation($requestData['dp_occupation']);
        $request->setBiography($requestData['dp_biography']);
        $request->setIndustry($requestData['dp_industry']);

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $resource->updateUser($request);
    }

    public function testGetUserData(): void
    {
        $requestData = [
            'dp_command' => 'getUserData',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_user_id' => 123,
            'dp_datetime_format' => 'datetime',
        ];

        $responseData = [
            'type' => 'success',
            'email' => 'email@test.com',
            'balance' => 102.46,
            'firstName' => 'Test',
            'lastName' => 'Test',
            'gender' => 'male',
            'news' => 'no',
            'address' => 'my address',
            'city' => 'Kyiv',
            'phone' => '',
            'status' => 'active',
            'state' => '',
            'timezone' => 'Europe/Kiev',
            'username' => 'testuser',
            'zip' => '12345',
            'createdAt' => 'Mar.21, 2020 12:41:16',
            'country' => 'Ukraine',
            'businessName' => '',
            'avatar' => 'https://depositphotos.com/....jpg',
            'biography' => null,
            'businessPhone' => '111222333',
            'company' => 'Company inc',
            'creditsAmount' => '87.00',
            'filesAmount' => 61,
            'invoiceAmount' => 17,
            'occupation' => null,
            'vatNumber' => null,
            'website' => 'http://test.com',
            'subscriptions' => [
                [
                    'name' => '1 month $69',
                    'status' => 'active',       
                    'purchaseMethod' => 'mes',
                    'dateBegin' => 'Mar.17, 2020 13:58:55',
                    'dateEnd' => 'Apr.16, 2020 14:58:55',
                    'period' => 30,
                    'amount' => 0
                ],
            ],
            'equipment' => null,
            'facebook' => '',
            'notifySales' => null,
            'notifySelection' => null,
            'industry' => null, 
        ];

        $resource = new UserResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getUserData(new GetUserDataRequest(
            $requestData['dp_session_id'],
            $requestData['dp_user_id'],
            $requestData['dp_datetime_format']
        ));

        $this->assertEquals($responseData['balance'], $result->getBalance());
        $this->assertEquals($responseData['status'], $result->getStatus());
        $this->assertEquals($responseData['timezone'], $result->getTimezone());
        $this->assertEquals($responseData['username'], $result->getUsername());
        $this->assertEquals($responseData['email'], $result->getEmail());
        $this->assertEquals($responseData['firstName'], $result->getFirstName());
        $this->assertEquals($responseData['lastName'], $result->getLastName());
        $this->assertEquals($responseData['gender'], $result->getGender());
        $this->assertEquals($responseData['news'], $result->getNews());
        $this->assertEquals($responseData['phone'], $result->getPhone());
        $this->assertEquals($responseData['businessName'], $result->getBusinessName());
        $this->assertEquals($responseData['facebook'], $result->getFacebook());
        $this->assertEquals($responseData['avatar'], $result->getAvatar());
        $this->assertEquals($responseData['company'], $result->getCompany());
        $this->assertEquals($responseData['address'], $result->getAddress());
        $this->assertEquals($responseData['city'], $result->getCity());
        $this->assertEquals($responseData['state'], $result->getState());
        $this->assertEquals($responseData['country'], $result->getCountry());
        $this->assertEquals($responseData['zip'], $result->getZip());
        $this->assertEquals($responseData['biography'], $result->getBiography());
        $this->assertEquals($responseData['businessPhone'], $result->getBusinessPhone());
        $this->assertEquals($responseData['creditsAmount'], $result->getCreditsAmount());
        $this->assertEquals($responseData['filesAmount'], $result->getFilesAmount());
        $this->assertEquals($responseData['invoiceAmount'], $result->getInvoiceAmount());
        $this->assertEquals($responseData['occupation'], $result->getOccupation());
        $this->assertEquals($responseData['vatNumber'], $result->getVatNumber());
        $this->assertEquals($responseData['website'], $result->getWebsite());
        $this->assertEquals($responseData['industry'], $result->getIndustry());
        $this->assertEquals($responseData['equipment'], $result->getEquipment());
        $this->assertEquals($responseData['notifySales'], $result->getNotifySales());
        $this->assertEquals($responseData['notifySelection'], $result->getNotifySelection());

        foreach ($result->getSubscriptions() as $key => $subscription) {
            $this->assertEquals($responseData['subscriptions'][$key], [
                'name' => $subscription->getName(),
                'status' => $subscription->getStatus(),
                'purchaseMethod' => $subscription->getPurchaseMethod(),
                'dateBegin' => $subscription->getDateBegin()->format(self::DATE_FORMAT),
                'dateEnd' => $subscription->getDateEnd()->format(self::DATE_FORMAT),
                'period' => $subscription->getPeriod(),
                'amount' => $subscription->getAmount(),
            ]);
        }
    }
}
