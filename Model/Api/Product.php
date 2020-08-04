<?php


namespace OpenApi\Model\Api;

use OpenApi\Annotations as OA;
use OpenApi\Service\ImageService;
use Thelia\Model\Country;
use Thelia\Model\ProductSaleElements;
use OpenApi\Constraint as Constraint;

/**
 * Class Product
 * @package OpenApi\Model\Api
 * @OA\Schema(
 *     description="A product"
 * )
 */
class Product extends BaseApiModel
{
    /**
     * @var integer
     * @OA\Property(
     *    type="integer",
     * )
     * @Constraint\NotBlank(groups={"read"})
     */
    protected $id;

    /**
     * @var string
     * @OA\Property(
     *     type="string",
     * )
     */
    protected $reference;

    /**
     * @var string
     * @OA\Property(
     *     type="string",
     * )
     */
    protected $url;

    /**
     * @var string
     * @OA\Property(
     *     type="string",
     * )
     */
    protected $title;

    /**
     * @var array
     * @OA\Property(
     *    type="array",
     *     @OA\Items(
     *          ref="#/components/schemas/Image"
     *     )
     * )
     */
    protected $images;

    /**
     * Create an OpenApi Product from a Thelia CartItem and a Country
     *
     * @param \Thelia\Model\CartItem $cartItem
     * @param Country $country
     * @param ImageService $imageService
     * @return $this
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function fillFromTheliaCartItemAndCountry(\Thelia\Model\CartItem $cartItem, Country $country)
    {
        $product = $cartItem->getProduct();

        $modelFactory = $this->modelFactory;
        $images = array_map(
            function ($productImage) use ($modelFactory) {
                return $modelFactory->buildModel('Image', $productImage);
            },
            iterator_to_array($product->getProductImages())
        );

        $this->id = $cartItem->getProductId();
        $this->reference = $product->getRef();
        $this->url = $product->getUrl();
        $this->title = $product->getTitle();
        $this->images = $images;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Product
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     * @return Product
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Product
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Product
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return array
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param array $images
     * @return Product
     */
    public function setImages($images)
    {
        $this->images = $images;
        return $this;
    }
}