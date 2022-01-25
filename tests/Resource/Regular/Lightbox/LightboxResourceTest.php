<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Tests\Resource\Regular\Lightbox;

use Depositphotos\SDK\Resource\Regular\Lightbox\LightboxResource;
use Depositphotos\SDK\Resource\Regular\Lightbox\Request\AddToLightboxRequest;
use Depositphotos\SDK\Resource\Regular\Lightbox\Request\CreateLightboxRequest;
use Depositphotos\SDK\Resource\Regular\Lightbox\Request\GetLightboxesRequest;
use Depositphotos\SDK\Resource\Regular\Lightbox\Request\GetLightboxRequest;
use Depositphotos\SDK\Resource\Regular\Lightbox\Request\RemoveFromLightboxRequest;
use Depositphotos\SDK\Resource\Regular\Lightbox\Request\RemoveLightboxRequest;
use Depositphotos\SDK\Resource\Regular\Lightbox\Request\SearchInLightboxRequest;
use Depositphotos\SDK\Resource\Regular\Lightbox\Request\UpdateLightboxRequest;
use Depositphotos\SDK\Resource\Regular\Lightbox\Response\Common\Lightbox;
use Depositphotos\SDK\Tests\BaseTestCase;
use Depositphotos\SDK\Tests\Resource\ResourceTrait;

class LightboxResourceTest extends BaseTestCase
{
    use ResourceTrait;

    private const DATE_FORMAT = 'M.d, Y H:i:s';

    public function testCreateLightbox(): void
    {
        $requestData = [
            'dp_command' => 'createLightbox',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_lightbox_title' => 'Title',
            'dp_lightbox_description' => 'Description',
        ];

        $responseData = [
            'type' => 'success',
            'lightbox' => [
                'lightboxId' => 168776182,
                'title' => 'Title',
                'description' => 'Description',
                'count' => 0,
                'created' => 'May.18, 2020 03:53:35',
                'updated' => 'May.18, 2020 03:53:35',
                'public' => false,
                'keywords' => '',
                'link' => 'http://depositphotos.com/folder/my-title-168776182.html',
                'userId' => '2066237',
                'userName' => 'photo_test1',
                'permission' => 'edit',
                'allowedActions' => [
                    'changeFiles',
                    'delete',
                    'shareEdit',
                    'shareView'
                ],
                'items' => [],
            ],
        ];

        $resource = new LightboxResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->createLightbox(new CreateLightboxRequest(
            $requestData['dp_session_id'],
            $requestData['dp_lightbox_title'],
            $requestData['dp_lightbox_description']
        ));

        $this->assertLightbox($responseData['lightbox'], $result->getLightbox());
    }

    public function testGetLightbox(): void
    {
        $requestData = [
            'dp_command' => 'getLightbox',
            'dp_lightbox_id' => 1,
            'dp_datetime_format' => null,
        ];

        $responseData = [
            'type' => 'success',
            'lightbox' => [
                'lightboxId' => 1,
                'title' => 'Title',
                'description' => 'Description',
                'count' => 0,
                'created' => 'May.18, 2020 03:53:35',
                'updated' => 'May.18, 2020 03:53:35',
                'public' => false,
                'keywords' => '',
                'link' => 'http://depositphotos.com/folder/my-title-168776182.html',
                'userId' => '2066237',
                'userName' => 'photo_test1',
                'permission' => 'edit',
                'allowedActions' => [
                    'changeFiles',
                    'delete',
                    'shareEdit',
                    'shareView'
                ],
                'items' => [],
            ],
        ];

        $resource = new LightboxResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getLightbox(new GetLightboxRequest(
            $requestData['dp_lightbox_id'],
            $requestData['dp_datetime_format']
        ));

        $this->assertLightbox($responseData['lightbox'], $result->getLightbox());
    }

    public function testGetLightboxes(): void
    {
        $requestData = [
            'dp_command' => 'getLightboxes',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_limit' => 1,
            'dp_offset' => 0,
            'dp_datetime_format' => null,
            'dp_thumb_size' => null,
            'dp_thumb_limit' => null,
            'dp_thumb_offset' => null,
        ];

        $responseData = [
            'type' => 'success',
            'lightboxes' => [
                [
                    'lightboxId' => 1,
                    'title' => 'Title',
                    'description' => 'Description',
                    'count' => 0,
                    'created' => 'May.18, 2020 03:53:35',
                    'updated' => 'May.18, 2020 03:53:35',
                    'public' => false,
                    'keywords' => '',
                    'link' => 'http://depositphotos.com/folder/my-title-168776182.html',
                    'userId' => '2066237',
                    'userName' => 'photo_test1',
                    'permission' => 'edit',
                    'allowedActions' => [
                        'changeFiles',
                        'delete',
                        'shareEdit',
                        'shareView'
                    ],
                    'items' => [],
                ]
            ],
            'count' => 2,
        ];

        $resource = new LightboxResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getLightboxes(new GetLightboxesRequest(
            $requestData['dp_session_id'],
            $requestData['dp_limit'],
            $requestData['dp_offset']
        ));

        $this->assertEquals($responseData['count'], $result->getCount());

        foreach ($result->getLightboxes() as $key => $lightbox) {
            $this->assertLightbox($responseData['lightboxes'][$key], $lightbox);
        }
    }

    public function testUpdateLightbox(): void
    {
        $requestData = [
            'dp_command' => 'updateLightbox',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_lightbox_id' => 1,
            'dp_lightbox_title' => 'Title',
            'dp_lightbox_description' => 'Description',
            'dp_lightbox_public' => true,
        ];

        $responseData = [
            'type' => 'success',
            'lightbox' => [
                'lightboxId' => 1,
                'title' => 'Title',
                'description' => 'Description',
                'count' => 0,
                'created' => 'May.18, 2020 03:53:35',
                'updated' => 'May.18, 2020 03:53:35',
                'public' => true,
                'keywords' => '',
                'link' => 'http://depositphotos.com/folder/my-title-168776182.html',
                'userId' => '2066237',
                'userName' => 'photo_test1',
                'permission' => 'edit',
                'allowedActions' => [
                    'changeFiles',
                    'delete',
                    'shareEdit',
                    'shareView'
                ],
                'items' => [],
            ],
        ];

        $resource = new LightboxResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->updateLightbox(new UpdateLightboxRequest(
            $requestData['dp_session_id'],
            $requestData['dp_lightbox_id'],
            $requestData['dp_lightbox_title'],
            $requestData['dp_lightbox_description'],
            $requestData['dp_lightbox_public']
        ));

        $this->assertLightbox($responseData['lightbox'], $result->getLightbox());
    }

    public function testRemoveLightbox(): void
    {
        $requestData = [
            'dp_command' => 'removeLightbox',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_lightbox_id' => 1
        ];

        $responseData = [
            'type' => 'success',
        ];

        $resource = new LightboxResource($this->createHttpClient($requestData, $responseData));
        $resource->removeLightbox(new RemoveLightboxRequest(
            $requestData['dp_session_id'],
            $requestData['dp_lightbox_id']
        ));
    }

    public function testAddToLightbox(): void
    {
        $requestData = [
            'dp_command' => 'addToLightbox',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_lightbox_id' => 1,
            'dp_media_id' => [1],
        ];

        $responseData = [
            'type' => 'success',
            'items' => [
                [
                    'id' => 1,
                    'title' => 'Gorgeous brunette woman.',
                    'description' => 'Portrait of elegantly dressed young gorgeous brunette woman.',
                    'width' => '2584',
                    'height' => '3000',
                    'mp' => '7.75',
                    'username' => 'envivo',
                    'status' => 'active',
                    'views' => 17166,
                    'downloads' => 1268,
                    'level' => 'silver',
                    'similar' => [
                        157798924,
                        117883264,
                    ],
                    'userid' => 1345889,
                    'published' => 'Jan.31, 2013 17:29:17',
                    'updated' => 'Jul.08, 2019 16:11:49',
                    'iseditorial' => false,
                    'itype' => 'image',
                    'thumbnail' => 'https://st.depositphotos.com/1345889/1947/i/110/depositphotos_19478735-stock-photo-gorgeous-brunette-woman.jpg',
                    'medium_thumbnail' => 'https://st.depositphotos.com/1345889/1947/i/170/depositphotos_19478735-stock-photo-gorgeous-brunette-woman.jpg',
                    'large_thumb' => 'https://st.depositphotos.com/1345889/1947/i/380/depositphotos_19478735-stock-photo-gorgeous-brunette-woman.jpg',
                    'huge_thumb' => 'https://st.depositphotos.com/1345889/1947/i/450/depositphotos_19478735-stock-photo-gorgeous-brunette-woman.jpg',
                    'url' => 'https://st.depositphotos.com/1345889/1947/i/110/depositphotos_19478735-stock-photo-gorgeous-brunette-woman.jpg',
                    'url2' => 'https://st.depositphotos.com/thumbs/1345889/image/1947/19478735/api_thumb_450.jpg',
                    'url_big' => 'https://st.depositphotos.com/1345889/1947/i/950/depositphotos_19478735-stock-photo-gorgeous-brunette-woman.jpg',
                    'url_max_qa' => 'https://st.depositphotos.com/thumbs/1345889/image/1947/19478735/api_thumb_450.jpg',
                    'itemurl' => 'https://depositphotos.com/19478735/stock-photo-gorgeous-brunette-woman.html',
                    'added' => null,
                    'sizeMask' => 30767,
                    'lightbox_discount' => 0
                ]
            ]
        ];

        $resource = new LightboxResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->addToLightbox(new AddToLightboxRequest(
            $requestData['dp_session_id'],
            $requestData['dp_lightbox_id'],
            $requestData['dp_media_id']
        ));

        foreach ($result->getItems() as $key => $item) {
            $this->assertEquals($responseData['items'][$key]['id'], $item->getId());
            $this->assertEquals($responseData['items'][$key]['title'], $item->getTitle());
            $this->assertEquals($responseData['items'][$key]['description'], $item->getDescription());
            $this->assertEquals($responseData['items'][$key]['width'], $item->getWidth());
            $this->assertEquals($responseData['items'][$key]['height'], $item->getHeight());
            $this->assertEquals($responseData['items'][$key]['mp'], $item->getMp());
            $this->assertEquals($responseData['items'][$key]['username'], $item->getUsername());
            $this->assertEquals($responseData['items'][$key]['status'], $item->getStatus());
            $this->assertEquals($responseData['items'][$key]['views'], $item->getViews());
            $this->assertEquals($responseData['items'][$key]['downloads'], $item->getDownloads());
            $this->assertEquals($responseData['items'][$key]['level'], $item->getLevel());
            $this->assertEquals($responseData['items'][$key]['similar'], $item->getSimilar());
            $this->assertEquals($responseData['items'][$key]['userid'], $item->getUserId());
            $this->assertEquals($responseData['items'][$key]['published'], $item->getPublished()->format(self::DATE_FORMAT));
            $this->assertEquals($responseData['items'][$key]['updated'], $item->getUpdated()->format(self::DATE_FORMAT));
            $this->assertEquals($responseData['items'][$key]['iseditorial'], $item->isEditorial());
            $this->assertEquals($responseData['items'][$key]['itype'], $item->getType());
            $this->assertEquals($responseData['items'][$key]['thumbnail'], $item->getThumbnail());
            $this->assertEquals($responseData['items'][$key]['medium_thumbnail'], $item->getMediumThumbnail());
            $this->assertEquals($responseData['items'][$key]['large_thumb'], $item->getLargeThumbnail());
            $this->assertEquals($responseData['items'][$key]['huge_thumb'], $item->getHugeThumbnail());
            $this->assertEquals($responseData['items'][$key]['url'], $item->getUrl());
            $this->assertEquals($responseData['items'][$key]['url2'], $item->getUrl2());
            $this->assertEquals($responseData['items'][$key]['url_big'], $item->getBigThumbnail());
            $this->assertEquals($responseData['items'][$key]['url_max_qa'], $item->getMaxQaUrl());
            $this->assertEquals($responseData['items'][$key]['itemurl'], $item->getItemUrl());
            $this->assertEquals($responseData['items'][$key]['added'], $item->getAdded());
            $this->assertEquals($responseData['items'][$key]['sizeMask'], $item->getSizeMask());
            $this->assertEquals($responseData['items'][$key]['lightbox_discount'], $item->getLightboxDiscount());
        }
    }

    public function testRemoveFromLightbox(): void
    {
        $requestData = [
            'dp_command' => 'removeFromLightbox',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_lightbox_id' => 1,
            'dp_media_id' => [1],
        ];

        $responseData = [
            'type' => 'success',
        ];

        $resource = new LightboxResource($this->createHttpClient($requestData, $responseData));
        $resource->removeFromLightbox(new RemoveFromLightboxRequest(
            $requestData['dp_session_id'],
            $requestData['dp_lightbox_id'],
            $requestData['dp_media_id']
        ));
    }

    public function testSearchInLightbox(): void
    {
        $requestData = [
            'dp_command' => 'searchInLightbox',
            'dp_limit' => 1,
            'dp_offset' => 0,
            'dp_lightbox_id' => 1,
            'dp_query' => 'cat',
            'dp_search_hash' => null,
            'dp_search_photo' => null,
            'dp_search_vector' => null,
            'dp_search_video' => null,
            'dp_search_audio' => null,
            'dp_search_editorial' => null,
        ];

        $responseData = [
            'type' => 'success',
            'result' => [
                [
                    'id' => 1011960,
                    'title' => 'Cat',
                    'description' => 'Cat',
                    'width' => '4559',
                    'height' => '3039',
                    'mp' => '13.85',
                    'status' => 'active',
                    'views' => 145,
                    'downloads' => 7,
                    'categories' => [],
                    'published' => 'Nov.12, 2009 14:33:49',
                    'username' => 'Reamonn',
                    'level' => 'silver',
                    'sizes' => null,
                    'upload_timestamp' => '1257931092',
                    'userid' => 1000118,
                    'blocked' => false,
                    'updated' => 'Aug.31, 2015 15:37:44',
                    'isextended' => true,
                    'isexclusive' => false,
                    'nudity' => false,
                    'iseditorial' => false,
                    'isFreeItem' => false,
                    'is_mobile' => 'no',
                    'type' => 'image',
                    'itype' => 'image',
                    'original_filesize' => '10446361',
                    'original_extension' => 'jpg',
                    'thumbnail' => 'https://static3.depositphotos.com/thumbs/1000118/image/101/1011960/thumb_110.jpg?forcejpeg=true',
                    'thumb_max' => 'https://static3.depositphotos.com/1000118/101/i/950/depositphotos_1011960-stock-photo-cat.jpg?forcejpeg=true',
                    'medium_thumbnail' => 'https://static3.depositphotos.com/thumbs/1000118/image/101/1011960/thumb_170.jpg?forcejpeg=true',
                    'large_thumb' => 'https://static3.depositphotos.com/1000118/101/i/380/depositphotos_1011960-stock-photo-cat.jpg?forcejpeg=true',
                    'url_big' => 'https://static3.depositphotos.com/1000118/101/i/950/depositphotos_1011960-stock-photo-cat.jpg?forcejpeg=true',
                    'url_max_qa' => 'https://static3.depositphotos.com/thumbs/1000118/image/101/1011960/api_thumb_450.jpg?forcejpeg=true',
                    'thumb_170' => 'https://static3.depositphotos.com/1000118/101/i/170/depositphotos_1011960-stock-photo-cat.jpg?forcejpeg=true',
                    'huge_thumb' => 'https://static3.depositphotos.com/1000118/101/i/450/depositphotos_1011960-stock-photo-cat.jpg?forcejpeg=true',
                    'url' => 'https://static3.depositphotos.com/thumbs/1000118/image/101/1011960/thumb_110.jpg?forcejpeg=true',
                    'url2' => 'https://static3.depositphotos.com/thumbs/1000118/image/101/1011960/api_thumb_450.jpg?forcejpeg=true',
                    'tags' => [],
                    'itemurl' => 'https://ayakymenko.dev/1011960/stock-photo-cat.html',
                    'royalty_model' => 'cpa',
                ]
            ],
            'hash' => 'e4e416d66e73b17d028721b4d04b8aa5',
            'count' => 100,
        ];

        $resource = new LightboxResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->searchInLightbox(new SearchInLightboxRequest(
            $requestData['dp_lightbox_id'],
            $requestData['dp_limit'],
            $requestData['dp_offset'],
            $requestData['dp_query']
        ));

        foreach ($result->getItems() as $key => $item) {
            $this->assertEquals($responseData['result'][$key]['id'], $item->getId());
            $this->assertEquals($responseData['result'][$key]['title'], $item->getTitle());
            $this->assertEquals($responseData['result'][$key]['description'], $item->getDescription());
            $this->assertEquals($responseData['result'][$key]['width'], $item->getWidth());
            $this->assertEquals($responseData['result'][$key]['height'], $item->getHeight());
            $this->assertEquals($responseData['result'][$key]['mp'], $item->getMp());
            $this->assertEquals($responseData['result'][$key]['username'], $item->getUsername());
            $this->assertEquals($responseData['result'][$key]['status'], $item->getStatus());
            $this->assertEquals($responseData['result'][$key]['views'], $item->getViews());
            $this->assertEquals($responseData['result'][$key]['downloads'], $item->getDownloads());
            $this->assertEquals($responseData['result'][$key]['level'], $item->getLevel());
            $this->assertEquals($responseData['result'][$key]['userid'], $item->getUserId());
            $this->assertEquals($responseData['result'][$key]['published'], $item->getPublished()->format(self::DATE_FORMAT));
            $this->assertEquals($responseData['result'][$key]['updated'], $item->getUpdated()->format(self::DATE_FORMAT));
            $this->assertEquals($responseData['result'][$key]['iseditorial'], $item->isEditorial());
            $this->assertEquals($responseData['result'][$key]['itype'], $item->getType());
            $this->assertEquals($responseData['result'][$key]['thumbnail'], $item->getThumbnail());
            $this->assertEquals($responseData['result'][$key]['medium_thumbnail'], $item->getMediumThumbnail());
            $this->assertEquals($responseData['result'][$key]['large_thumb'], $item->getLargeThumbnail());
            $this->assertEquals($responseData['result'][$key]['huge_thumb'], $item->getHugeThumbnail());
            $this->assertEquals($responseData['result'][$key]['url'], $item->getUrl());
            $this->assertEquals($responseData['result'][$key]['url2'], $item->getUrl2());
            $this->assertEquals($responseData['result'][$key]['url_big'], $item->getBigThumbnail());
            $this->assertEquals($responseData['result'][$key]['url_max_qa'], $item->getMaxQaUrl());
            $this->assertEquals($responseData['result'][$key]['itemurl'], $item->getItemUrl());
            $this->assertEquals($responseData['result'][$key]['isextended'], $item->isExtended());
            $this->assertEquals($responseData['result'][$key]['isexclusive'], $item->isExclusive());
            $this->assertEquals($responseData['result'][$key]['nudity'], $item->isNudity());
            $this->assertEquals($responseData['result'][$key]['isFreeItem'], $item->isFree());
            $this->assertEquals($responseData['result'][$key]['blocked'], $item->isBlocked());
            $this->assertEquals($responseData['result'][$key]['upload_timestamp'], $item->getUploaded()->getTimestamp());
            $this->assertEquals($responseData['result'][$key]['original_filesize'], $item->getOriginalFilesize());
            $this->assertEquals($responseData['result'][$key]['original_extension'], $item->getOriginalExtension());
            $this->assertEquals($responseData['result'][$key]['tags'], $item->getTags());
        }
    }
    
    private function assertLightbox(array $expected, Lightbox $lightbox): void
    {
        $this->assertEquals($expected['lightboxId'], $lightbox->getId());
        $this->assertEquals($expected['title'], $lightbox->getTitle());
        $this->assertEquals($expected['description'], $lightbox->getDescription());
        $this->assertEquals($expected['count'], $lightbox->getCount());
        $this->assertEquals($expected['created'], $lightbox->getCreated()->format(self::DATE_FORMAT));
        $this->assertEquals($expected['updated'], $lightbox->getUpdated()->format(self::DATE_FORMAT));
        $this->assertEquals($expected['public'], $lightbox->isPublic());
        $this->assertEquals($expected['keywords'], $lightbox->getKeywords());
        $this->assertEquals($expected['link'], $lightbox->getLink());
        $this->assertEquals($expected['userId'], $lightbox->getUserId());
        $this->assertEquals($expected['userName'], $lightbox->getUsername());
        $this->assertEquals($expected['permission'], $lightbox->getPermission());
        $this->assertEquals($expected['allowedActions'], $lightbox->getAllowedActions());
        $this->assertEquals($expected['items'], $lightbox->getItems());
    }
}
