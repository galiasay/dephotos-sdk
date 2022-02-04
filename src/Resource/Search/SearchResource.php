<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Search;

use Depositphotos\SDK\Resource\Search\Request\GetChangedItemsRequest;
use Depositphotos\SDK\Resource\Search\Request\GetMediaDataRequest;
use Depositphotos\SDK\Resource\Search\Request\GetRelatedRequest;
use Depositphotos\SDK\Resource\Search\Request\GetSearchColorsRequest;
use Depositphotos\SDK\Resource\Search\Request\GetTagCloudRequest;
use Depositphotos\SDK\Resource\Search\Request\SearchHintsRequest;
use Depositphotos\SDK\Resource\Search\Request\SearchRequest;
use Depositphotos\SDK\Resource\Search\Response\GetChangedItemsResponse;
use Depositphotos\SDK\Resource\Search\Response\GetMediaDataResponse;
use Depositphotos\SDK\Resource\Search\Response\GetRelatedResponse;
use Depositphotos\SDK\Resource\Search\Response\GetSearchColorsResponse;
use Depositphotos\SDK\Resource\Search\Response\GetTagCloudResponse;
use Depositphotos\SDK\Resource\Search\Response\SearchHintResponse;
use Depositphotos\SDK\Resource\Search\Response\SearchResponse;
use Depositphotos\SDK\Resource\Resource;

class SearchResource extends Resource
{
    public function search(SearchRequest $request): SearchResponse
    {
        $httpResponse = $this->send($request);

        return new SearchResponse($this->convertHttpResponseToArray($httpResponse));
    }

    public function getChangedItems(GetChangedItemsRequest $request): GetChangedItemsResponse
    {
        $httpResponse = $this->send($request);

        return new GetChangedItemsResponse($this->convertHttpResponseToArray($httpResponse));
    }

    public function getRelated(GetRelatedRequest $request): GetRelatedResponse
    {
        $httpResponse = $this->send($request);

        return new GetRelatedResponse($this->convertHttpResponseToArray($httpResponse));
    }

    public function getSearchColors(GetSearchColorsRequest $request): GetSearchColorsResponse
    {
        $httpResponse = $this->send($request);

        return new GetSearchColorsResponse($this->convertHttpResponseToArray($httpResponse));
    }

    public function searchHints(SearchHintsRequest $request): SearchHintResponse
    {
        $httpResponse = $this->send($request);

        return new SearchHintResponse($this->convertHttpResponseToArray($httpResponse));
    }

    public function getTagCloud(GetTagCloudRequest $request): GetTagCloudResponse
    {
        $httpResponse = $this->send($request);

        return new GetTagCloudResponse($this->convertHttpResponseToArray($httpResponse));
    }

    public function getMediaData(GetMediaDataRequest $request): GetMediaDataResponse
    {
        $httpResponse = $this->send($request);

        return new GetMediaDataResponse($this->convertHttpResponseToArray($httpResponse));
    }
}
