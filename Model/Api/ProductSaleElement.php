<?php


namespace OpenApi\Model\Api;

use OpenApi\Annotations as OA;
use Thelia\Model\Country;
use Thelia\Model\ProductSaleElements;
use OpenApi\Constraint as Constraint;

/**
 * Class ProductSaleElement
 * @package OpenApi\Model\Api
 * @OA\Schema(
 *     description="A product sale element"
 * )
 */
class ProductSaleElement extends BaseApiModel
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
     * @var boolean
     * @OA\Property(
     *    type="boolean",
     * )
     */
    protected $isPromo;

    /**
     * @var string
     * @OA\Property(
     *     type="string",
     * )
     */
    protected $reference;

    /**
     * @var array
     * @OA\Property(
     *    description="List of the attributes used by this pse",
     *    type="array",
     *     @OA\Items(
     *          ref="#/components/schemas/Attribute"
     *     )
     * )
     */
    protected $attributes;

    /**
     * @var Price
     * @OA\Property(
     *    type="object",
     *    ref="#/components/schemas/Price"
     * )
     */
    protected $price;

    /**
     * @var Price
     * @OA\Property(
     *    type="object",
     *    ref="#/components/schemas/Price"
     * )
     */
    protected $promoPrice;

    /**
     * Create an OpenApi ProductSaleElement from a Thelia ProductSaleElements and a Country, then returns it
     *
     * @param ProductSaleElements $pse
     * @param Country $country
     * @return $this
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function fillFromTheliaPseAndCountry(ProductSaleElements $pse, Country $country)
    {
        $modelFactory = $this->modelFactory;
        $attributes = array_map(
            function ($attributeCombination) use ($modelFactory){
                return $modelFactory->buildModel('Attribute', $attributeCombination);
            },
            iterator_to_array($pse->getAttributeCombinations())
        );

        $this->id = $pse->getId();
        $this->isPromo = (bool)$pse->getPromo();

        /** @var Price $price */
        $price = $this->modelFactory->buildModel('Price');
        $price->fillFromTheliaPseAndCountry($pse, $country);
        $this->price = $price;

        /** @var Price $promoPrice */
        $promoPrice = $this->modelFactory->buildModel('Price');
        $promoPrice->fillFromTheliaPseAndCountry($pse, $country);
        $this->promoPrice = $price;

        $this->reference = $pse->getRef();
        $this->attributes = $attributes;

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
     * @return ProductSaleElement
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPromo()
    {
        return $this->isPromo;
    }

    /**
     * @param bool $isPromo
     * @return ProductSaleElement
     */
    public function setIsPromo($isPromo)
    {
        $this->isPromo = $isPromo;
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
     * @return ProductSaleElement
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     * @return ProductSaleElement
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @return Price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param Price $price
     * @return ProductSaleElement
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return Price
     */
    public function getPromoPrice()
    {
        return $this->promoPrice;
    }

    /**
     * @param Price $promoPrice
     * @return ProductSaleElement
     */
    public function setPromoPrice($promoPrice)
    {
        $this->promoPrice = $promoPrice;
        return $this;
    }
}