<?php
/**
 * User: ms
 * Date: 12.10.15
 * Time: 22:16
 */

namespace Amazon;


class WishlistParser extends Parser
{
    /**
     * @var null
     */
    private $wishlistId = null;

    public function __construct($url)
    {
        parent::__construct($url);
        $urlParameter = parse_url($this->getUrl());

        $this->processWishListUrl($urlParameter);
    }

    protected function processWishListUrl($urlParameter)
    {
        $paramArray = explode('/', $urlParameter['path']);

        $this->wishlistId = $paramArray[4];

    }

    /**
     * @return null
     */
    public function getWishlistId()
    {
        return $this->wishlistId;
    }


}