<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Tests\Resource\Common\Search;

use Depositphotos\SDK\Resource\Common\Search\Request\GetChangedItemsRequest;
use Depositphotos\SDK\Resource\Common\Search\Request\GetMediaDataRequest;
use Depositphotos\SDK\Resource\Common\Search\Request\GetRelatedRequest;
use Depositphotos\SDK\Resource\Common\Search\Request\GetSearchColorsRequest;
use Depositphotos\SDK\Resource\Common\Search\Request\GetTagCloudRequest;
use Depositphotos\SDK\Resource\Common\Search\Request\SearchHintsRequest;
use Depositphotos\SDK\Resource\Common\Search\Request\SearchRequest;
use Depositphotos\SDK\Resource\Common\Search\Response\Common\Item;
use Depositphotos\SDK\Resource\Common\Search\Response\Common\Size;
use Depositphotos\SDK\Resource\Common\Search\Response\GetMediaData\Related;
use Depositphotos\SDK\Resource\Common\Search\SearchResource;
use Depositphotos\SDK\Tests\BaseTestCase;
use Depositphotos\SDK\Tests\Resource\ResourceTrait;

class SearchResourceTest extends BaseTestCase
{
    use ResourceTrait;

    private const DATE_FORMAT = 'M.d, Y H:i:s';

    public function testSearch(): void
    {
        $requestData = [
            'dp_command' => 'search',
            'dp_search_query' => 'woman',
            'dp_search_hash' => null,
            'dp_search_sort' => null,
            'dp_search_limit' => 10,
            'dp_search_offset' => 0,
            'dp_search_color' => null,
            'dp_search_nudity' => null,
            'dp_illustration' => null,
            'dp_search_user' => null,
            'dp_search_username' => null,
            'dp_search_orientation' => null,
            'dp_search_imagesize' => null,
            'dp_exclude_keywords' => null,
            'dp_search_photo' => null,
            'dp_search_vector' => null,
            'dp_search_video' => null,
            'dp_search_audio' => null,
            'dp_search_music' => null,
            'dp_search_sound_effect' => null,
            'dp_search_editorial' => null,
            'dp_tracking_url' => null,
            'dp_country_excluded' => null,
            'dp_translate_items' => null,
            'dp_lang' => null,
            'dp_search_correction' => null,
            'dp_search_height' => null,
            'dp_search_width' => null,
            'dp_image_url' => null,
            'dp_search_gender' => null,
            'dp_search_age' => null,
            'dp_search_race' => null,
            'dp_search_quantity' => null,
        ];

        $responseData = [
            'type' => 'success',
            'count' => 13009933,
            'result' => [
                [
                    'title' => 'Fashionable young brunette.',
                    'description' => 'Portrait of an attractive fashionable young brunette woman.',
                    'width' => '4741',
                    'height' => '3986',
                    'mp' => '18.9',
                    'status' => 'active',
                    'views' => 13768,
                    'downloads' => 1262,
                    'published' => 'Feb.18, 2013 20:07:26',
                    'username' => 'envivo',
                    'level' => 'silver',
                    'sizes' => null,
                    'upload_timestamp' => '1360670344',
                    'id' => '20192481',
                    'userid' => 1345889,
                    'user_id' => 1345889,
                    'blocked' => false,
                    'updated' => 'Jul.09, 2019 19:13:56',
                    'isextended' => false,
                    'isexclusive' => false,
                    'nudity' => false,
                    'iseditorial' => false,
                    'isFreeItem' => false,
                    'is_mobile' => 'no',
                    'type' => 'image',
                    'original_filesize' => '9420996',
                    'original_extension' => 'jpg',
                    'thumbnail' => 'https://st.depo...thumb_110.jpg',
                    'thumb' => 'https://st.depo...thumb_110.jpg',
                    'thumb_large' => 'https://st.depo...thumb_170.jpg',
                    'thumb_huge' => 'https://st.depo...api_thumb_450.jpg',
                    'thumb_max' => 'https://st.depo...brunette.jpg',
                    'medium_thumbnail' => 'https://st.depo...thumb_170.jpg',
                    'large_thumb' => 'https://st.depos...brunette.jpg',
                    'url_big' => 'https://st.depo...brunette.jpg',
                    'url_max_qa' => 'https://st.depo...api_thumb_450.jpg',
                    'thumb_170' => 'https://st.depo...brunette.jpg',
                    'huge_thumb' => 'https://st.depo...brunette.jpg',
                    'url' => 'https://st.depo...thumb_110.jpg',
                    'url2' => 'https://st.depo...api_thumb_450.jpg',
                    'itemurl' => 'https://depo...brunette.html',
                    'avatar' => 'https://static.depo...1345889.jpg?b6de0bb2c7d4796899d47199531b0964',
                    'similar' => [
                        1034007,
                        1235904,
                    ],
                    'series' => [
                        1803161,
                    ],
                    'same_model' => [
                        1502128,
                    ],
                ],
            ],
            'hash' => uniqid(),
        ];

        $resource = new SearchResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->search(new SearchRequest(
            $requestData['dp_search_query'],
            $requestData['dp_search_limit'],
            $requestData['dp_search_offset']
        ));

        foreach ($result->getItems() as $key => $item) {
            $this->assertItem($responseData['result'][$key], $item);
            $this->assertEquals($responseData['result'][$key]['similar'], $item->getSimilar());
            $this->assertEquals($responseData['result'][$key]['series'], $item->getSeries());
            $this->assertEquals($responseData['result'][$key]['same_model'], $item->getSameModel());
        }
    }

    public function testGetChangedItems(): void
    {
        $requestData = [
            'dp_command' => 'getChangedItems',
            'datetime_from' => '2021-10-21 00:00:00',
            'datetime_to' => '2021-11-20 23:59:59',
            'dp_search_limit' => 10,
            'dp_search_offset' => 0,
        ];

        $responseData = [
            'type' => 'success',
            'count' => 10,
            'deleted' => [
                475076266
            ],
            'result' => [
                [
                    'title' => 'Fashionable young brunette.',
                    'description' => 'Portrait of an attractive fashionable young brunette woman.',
                    'width' => '4741',
                    'height' => '3986',
                    'mp' => '18.9',
                    'status' => 'active',
                    'views' => 13768,
                    'downloads' => 1262,
                    'published' => 'Feb.18, 2013 20:07:26',
                    'username' => 'envivo',
                    'level' => 'silver',
                    'upload_timestamp' => '1360670344',
                    'id' => '20192481',
                    'userid' => 1345889,
                    'user_id' => 1345889,
                    'blocked' => false,
                    'updated' => 'Jul.09, 2019 19:13:56',
                    'isextended' => false,
                    'isexclusive' => false,
                    'nudity' => false,
                    'iseditorial' => false,
                    'isFreeItem' => false,
                    'is_mobile' => 'no',
                    'type' => 'image',
                    'original_filesize' => '9420996',
                    'original_extension' => 'jpg',
                    'thumbnail' => 'https://st.depo...thumb_110.jpg',
                    'thumb' => 'https://st.depo...thumb_110.jpg',
                    'thumb_large' => 'https://st.depo...thumb_170.jpg',
                    'thumb_huge' => 'https://st.depo...api_thumb_450.jpg',
                    'thumb_max' => 'https://st.depo...brunette.jpg',
                    'medium_thumbnail' => 'https://st.depo...thumb_170.jpg',
                    'large_thumb' => 'https://st.depos...brunette.jpg',
                    'url_big' => 'https://st.depo...brunette.jpg',
                    'url_max_qa' => 'https://st.depo...api_thumb_450.jpg',
                    'thumb_170' => 'https://st.depo...brunette.jpg',
                    'huge_thumb' => 'https://st.depo...brunette.jpg',
                    'url' => 'https://st.depo...thumb_110.jpg',
                    'url2' => 'https://st.depo...api_thumb_450.jpg',
                    'itemurl' => 'https://depo...brunette.html',
                    'avatar' => 'https://static.depo...1345889.jpg?b6de0bb2c7d4796899d47199531b0964',
                    'sizes' => [
                        's' => [
                            'width' => 500,
                            'height' => 333,
                            'credits' => 1,
                            'subscription' => 1,
                            'imagepack' => 0,
                            'ondemand' => 1,
                            'mp' => 0.5,
                        ],
                        'm' => [
                            'width' => 1000,
                            'height' => 667,
                            'credits' => 3,
                            'subscription' => 1,
                            'imagepack' => 0,
                            'ondemand' => 1,
                            'mp' => 2,
                        ],
                        'l' => [
                            'width' => 2000,
                            'height' => 1333,
                            'credits' => 6,
                            'subscription' => 1,
                            'imagepack' => 0,
                            'ondemand' => 1,
                            'mp' => 8,
                        ],
                        'xl' => [
                            'width' => 5940,
                            'height' => 3960,
                            'credits' => 10,
                            'subscription' => 1,
                            'imagepack' => 0,
                            'ondemand' => 1,
                            'mp' => 15,
                        ],
                    ],
                ],
            ],
        ];

        $resource = new SearchResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getChangedItems(new GetChangedItemsRequest(
            new \DateTime($requestData['datetime_from']),
            new \DateTime($requestData['datetime_to']),
            $requestData['dp_search_limit'],
            $requestData['dp_search_offset']
        ));

        $this->assertEquals($responseData['count'], $result->getCount());
        $this->assertEquals($responseData['deleted'], $result->getDeleted());

        foreach ($result->getItems() as $key => $item) {
            $this->assertItem($responseData['result'][$key], $item);

            foreach ($item->getSizes() as $size) {
                $this->assertSize($responseData['result'][$key]['sizes'][$size->getName()], $size);
            }
        }
    }

    public function testGetRelated(): void
    {
        $requestData = [
            'dp_command' => 'getRelated',
            'dp_search_item_id' => 1,
            'dp_related_type' => 'similar',
            'dp_limit' => 10,
            'dp_offset' => 0,
        ];

        $responseData = [
            'type' => 'success',
            'items' => [
                [
                    'title' => 'Fashionable young brunette.',
                    'description' => 'Portrait of an attractive fashionable young brunette woman.',
                    'width' => '4741',
                    'height' => '3986',
                    'mp' => '18.9',
                    'status' => 'active',
                    'views' => 13768,
                    'downloads' => 1262,
                    'published' => 'Feb.18, 2013 20:07:26',
                    'username' => 'envivo',
                    'level' => 'silver',
                    'sizes' => null,
                    'upload_timestamp' => '1360670344',
                    'id' => '20192481',
                    'userid' => 1345889,
                    'user_id' => 1345889,
                    'blocked' => false,
                    'updated' => 'Jul.09, 2019 19:13:56',
                    'isextended' => false,
                    'isexclusive' => false,
                    'nudity' => false,
                    'iseditorial' => false,
                    'isFreeItem' => false,
                    'is_mobile' => 'no',
                    'type' => 'image',
                    'original_filesize' => '9420996',
                    'original_extension' => 'jpg',
                    'thumbnail' => 'https://st.depo...thumb_110.jpg',
                    'thumb' => 'https://st.depo...thumb_110.jpg',
                    'thumb_large' => 'https://st.depo...thumb_170.jpg',
                    'thumb_huge' => 'https://st.depo...api_thumb_450.jpg',
                    'thumb_max' => 'https://st.depo...brunette.jpg',
                    'medium_thumbnail' => 'https://st.depo...thumb_170.jpg',
                    'large_thumb' => 'https://st.depos...brunette.jpg',
                    'url_big' => 'https://st.depo...brunette.jpg',
                    'url_max_qa' => 'https://st.depo...api_thumb_450.jpg',
                    'thumb_170' => 'https://st.depo...brunette.jpg',
                    'huge_thumb' => 'https://st.depo...brunette.jpg',
                    'url' => 'https://st.depo...thumb_110.jpg',
                    'url2' => 'https://st.depo...api_thumb_450.jpg',
                    'itemurl' => 'https://depo...brunette.html',
                    'avatar' => 'https://static.depo...1345889.jpg?b6de0bb2c7d4796899d47199531b0964',
                ],
            ],
            'count' => 100,
        ];

        $resource = new SearchResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getRelated(new GetRelatedRequest(
            $requestData['dp_search_item_id'],
            $requestData['dp_related_type'],
            $requestData['dp_limit'],
            $requestData['dp_offset']
        ));

        $this->assertEquals($responseData['count'], $result->getCount());

        foreach ($result->getItems() as $key => $item) {
            $this->assertItem($responseData['items'][$key], $item);
        }
    }

    public function testGetSearchColors(): void
    {
        $requestData = [
            'dp_command' => 'getSearchColors',
        ];

        $responseData = [
            'type' => 'success',
            'result' => [
                [
                    'id' => 1,
                    'hex' => '#00007c',
                ],
                [
                    'id' => 2,
                    'hex' => '#0005fd',
                ],
            ],
        ];

        $resource = new SearchResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getSearchColors(new GetSearchColorsRequest());

        foreach ($result->getColors() as $key => $color) {
            $this->assertEquals($responseData['result'][$key]['id'], $color->getId());
            $this->assertEquals($responseData['result'][$key]['hex'], $color->getHex());
        }
    }

    public function testSearchHint(): void
    {
        $requestData = [
            'dp_command' => 'searchHint',
            'dp_search_prefix' => 'cat',
            'dp_language' => 'en',
        ];

        $responseData = [
            'type' => 'success',
            'hints' => [
                'cat silhouette',
                'cat dog',
                'cattle',
                'cats and dogs',
                'catrina',
                'cat vector',
                'cat eating',
                'cat food',
                'catering service',
                'catering food',
            ],
            'prefix' => 'cat'
        ];

        $resource = new SearchResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->searchHints(new SearchHintsRequest(
            $requestData['dp_search_prefix'],
            $requestData['dp_language']
        ));

        $this->assertEquals($responseData['hints'], $result->getHints());
        $this->assertEquals($responseData['prefix'], $result->getPrefix());
    }

    public function testGetTagCloud(): void
    {
        $requestData = [
            'dp_command' => 'getTagCloud',
            'dp_type' => 'image',
        ];

        $responseData = [
            'type' => 'success',
            'result' => [
                [
                    'name' => [
                        'id' => '2112152',
                        'date' => '2020-03-17 17:37:49',
                        'lang' => 'en',
                        'phrase' => 'Christmas',
                        'type' => 'image'
                    ],
                    'rate' => 30
                ],
            ],
        ];

        $resource = new SearchResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getTagCloud(new GetTagCloudRequest($requestData['dp_type']));

        foreach ($result->getTags() as $key => $tag) {
            $this->assertEquals($responseData['result'][$key]['name']['id'], $tag->getId());
            $this->assertEquals($responseData['result'][$key]['name']['date'], $tag->getDate()->format('Y-m-d H:i:s'));
            $this->assertEquals($responseData['result'][$key]['name']['lang'], $tag->getLang());
            $this->assertEquals($responseData['result'][$key]['name']['phrase'], $tag->getPhrase());
            $this->assertEquals($responseData['result'][$key]['name']['type'], $tag->getType());
            $this->assertEquals($responseData['result'][$key]['rate'], $tag->getRate());
        }
    }

    public function testGetMediaData(): void
    {
        $requestData = [
            'dp_command' => 'getMediaData',
            'dp_media_id' => 1,
            'dp_full_similar' => false,
            'dp_translate_items' => false,
            'dp_lang' => null,
            'dp_datetime_format' => null,
            'dp_country_excluded' => null,
        ];

        $responseData = [
            'type' => 'success',
            'title' => 'Gorgeous brunette woman.',
            'description' => 'Portrait of elegantly dressed young gorgeous brunette woman.',
            'width' => '2584',
            'height' => '3000',
            'mp' => '7.75',
            'status' => 'active',
            'views' => 17225,
            'downloads' => 1269,
            'published' => 'Jan.31, 2013 15:29:17',
            'username' => 'envivo',
            'level' => 'silver',
            'sizes' => [
                's' => [
                    'width' => 431,
                    'height' => 500,
                    'credits' => 1,
                    'subscription' => 1,
                    'imagepack' => 0,
                    'ondemand' => 1,
                    'mp' => 0.5
                ],
                'm' => [
                    'width' => 861,
                    'height' => 1000,
                    'credits' => 3,
                    'subscription' => 1,
                    'imagepack' => 0,
                    'ondemand' => 1,
                    'mp' => 2
                ],
                'l' => [
                    'width' => 1723,
                    'height' => 2000,
                    'credits' => 6,
                    'subscription' => 1,
                    'imagepack' => 0,
                    'ondemand' => 1,
                    'mp' => 8
                ],
                'xl' => [
                    'width' => 2584,
                    'height' => 3000,
                    'credits' => 10,
                    'subscription' => 1,
                    'imagepack' => 0,
                    'ondemand' => 1,
                    'mp' => 15
                ]
            ],
            'upload_timestamp' => '1359471261',
            'id' => '19478735',
            'userid' => 1345889,
            'blocked' => false,
            'updated' => 'Jul.08, 2019 13:11:49',
            'isextended' => true,
            'isexclusive' => false,
            'nudity' => false,
            'iseditorial' => false,
            'isFreeItem' => false,
            'original_filesize' => '3675812',
            'original_extension' => 'jpg',
            'thumbnail' => 'https://st.depo...thumb_110.jpg',
            'thumb' => 'https://st.depos...thumb_110.jpg',
            'medium_thumbnail' => 'https://st.depo...thumb_170.jpg',
            'large_thumb' => 'https://st.depo...woman.jpg',
            'url_big' => 'https://st.depo...woman.jpg',
            'url_max_qa' => 'https://st.depo...thumb_450.jpg',
            'huge_thumb' => 'https://st.depo...woman.jpg',
            'url' => 'https://st.depo...thumb_110.jpg',
            'url2' => 'https://st.depo...thumb_450.jpg',
            'itemurl' => 'https://depo...woman.html',
            'avatar' => null,
            'tags' => [
                'fun',
                'blue',
                'copy',
            ],
            'similar' => [
                '4176925' => [
                    'id' => 4176925,
                    'thumbnail' => 'https://st.depo...thumb_110.jpg',
                    'large_thumb' => 'https://st.depo...thumb_110.jpg',
                    'huge_thumb' => 'https://st.depo...thumb_110.jpg',
                    'title' => 'Hardworking ant',
                    'description' => 'An ant and a coin',
                    'height' => 1600,
                    'width' => 3287,
                    'thumb_neutral_wm' => 'https://st.depo...thumb_110.jpg',
                    'url_max_qa' => 'https://st.depo...thumb_110.jpg',
                    'itemurl' => 'https://depo...ant.html',
                    'original_title' => 'Hardworking ant',
                    'original_description' => 'An ant and a coin',
                    'isFreeItem' => false,
                    'type' => 'vector',
                ],
            ],
            'series' => [
                '2870850' => [
                    'id' => 2870850,
                    'thumbnail' => 'https://st.depo...thumb_110.jpg',
                    'large_thumb' => 'https://st.depo...thumb_110.jpg',
                    'huge_thumb' => 'https://st.depo...thumb_110.jpg',
                    'title' => 'Clown fish',
                    'description' => 'Vector illustration of fishes on a blue background',
                    'height' => 3751,
                    'width' => 5001,
                    'thumb_neutral_wm' => 'https://st.depo...thumb_110.jpg',
                    'url_max_qa' => 'https://st.depo...thumb_110.jpg',
                    'itemurl' => 'https://depo...fish.html',
                    'original_title' => 'Clown fish',
                    'original_description' => 'Vector illustration of fishes on a blue background',
                    'isFreeItem' => false,
                    'type' => 'vector',
                ],
            ],
        ];

        $resource = new SearchResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getMediaData(new GetMediaDataRequest(
            $requestData['dp_media_id'],
            $requestData['dp_full_similar'],
            $requestData['dp_translate_items'],
            $requestData['dp_lang'],
            $requestData['dp_datetime_format'],
            $requestData['dp_country_excluded']

        ));

        $this->assertItem($responseData, $result);

        foreach ($result->getSizes() as $size) {
            $this->assertSize($responseData['sizes'][$size->getName()], $size);
        }

        foreach ($result->getSimilar() as $related) {
            $this->assertRelated($responseData['similar'][$related->getId()], $related);
        }

        foreach ($result->getSeries() as $related) {
            $this->assertRelated($responseData['series'][$related->getId()], $related);
        }
    }
    
    private function assertItem(array $expected, Item $item): void
    {
        $this->assertEquals($expected['id'], $item->getId());
        $this->assertEquals($expected['title'], $item->getTitle());
        $this->assertEquals($expected['description'], $item->getDescription());
        $this->assertEquals($expected['width'], $item->getWidth());
        $this->assertEquals($expected['height'], $item->getHeight());
        $this->assertEquals($expected['mp'], $item->getMp());
        $this->assertEquals($expected['username'], $item->getUsername());
        $this->assertEquals($expected['status'], $item->getStatus());
        $this->assertEquals($expected['views'], $item->getViews());
        $this->assertEquals($expected['downloads'], $item->getDownloads());
        $this->assertEquals($expected['level'], $item->getLevel());
        $this->assertEquals($expected['userid'], $item->getUserId());
        $this->assertEquals($expected['published'], $item->getPublished()->format(self::DATE_FORMAT));
        $this->assertEquals($expected['updated'], $item->getUpdated()->format(self::DATE_FORMAT));
        $this->assertEquals($expected['iseditorial'], $item->isEditorial());
        $this->assertEquals($expected['type'], $item->getType());
        $this->assertEquals($expected['thumbnail'], $item->getThumbnail());
        $this->assertEquals($expected['medium_thumbnail'], $item->getMediumThumbnail());
        $this->assertEquals($expected['large_thumb'], $item->getLargeThumbnail());
        $this->assertEquals($expected['huge_thumb'], $item->getHugeThumbnail());
        $this->assertEquals($expected['url'], $item->getUrl());
        $this->assertEquals($expected['url2'], $item->getUrl2());
        $this->assertEquals($expected['url_big'], $item->getBigThumbnail());
        $this->assertEquals($expected['url_max_qa'], $item->getMaxQaUrl());
        $this->assertEquals($expected['itemurl'], $item->getItemUrl());
        $this->assertEquals($expected['isextended'], $item->isExtended());
        $this->assertEquals($expected['isexclusive'], $item->isExclusive());
        $this->assertEquals($expected['nudity'], $item->isNudity());
        $this->assertEquals($expected['isFreeItem'], $item->isFree());
        $this->assertEquals($expected['blocked'], $item->isBlocked());
        $this->assertEquals($expected['upload_timestamp'], $item->getUploaded()->getTimestamp());
        $this->assertEquals($expected['original_filesize'], $item->getOriginalFilesize());
        $this->assertEquals($expected['original_extension'], $item->getOriginalExtension());
    }

    private function assertSize(array $expected, Size $size): void
    {
        $this->assertEquals($expected['width'], $size->getWidth());
        $this->assertEquals($expected['height'], $size->getHeight());
        $this->assertEquals($expected['credits'], $size->getCredits());
        $this->assertEquals($expected['subscription'], $size->getSubscription());
        $this->assertEquals($expected['imagepack'], $size->getImagePack());
        $this->assertEquals($expected['ondemand'], $size->getOnDemand());
        $this->assertEquals($expected['mp'], $size->getMp());
    }

    private function assertRelated(array $expected, Related $related): void
    {
        $this->assertEquals($expected['id'], $related->getId());
        $this->assertEquals($expected['thumbnail'], $related->getThumbnail());
        $this->assertEquals($expected['large_thumb'], $related->getLargeThumbnail());
        $this->assertEquals($expected['huge_thumb'], $related->getHugeThumbnail());
        $this->assertEquals($expected['title'], $related->getTitle());
        $this->assertEquals($expected['description'], $related->getDescription());
        $this->assertEquals($expected['thumb_neutral_wm'], $related->getNeutralWmThumbnail());
        $this->assertEquals($expected['url_max_qa'], $related->getMaxQaUrl());
        $this->assertEquals($expected['height'], $related->getHeight());
        $this->assertEquals($expected['width'], $related->getWidth());
        $this->assertEquals($expected['itemurl'], $related->getItemUrl());
        $this->assertEquals($expected['original_title'], $related->getOriginalTitle());
        $this->assertEquals($expected['original_description'], $related->getOriginalDescription());
        $this->assertEquals($expected['isFreeItem'], $related->isFreeItem());
        $this->assertEquals($expected['type'], $related->getType());
    }
}
