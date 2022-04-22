<?php
namespace Training\Blog\Ui\Component\Create\Form\Customer;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Framework\App\RequestInterface;

/**
 * Options tree for "Categories" field
 */
class ProductOptions implements OptionSourceInterface
{
    /**
     * @var ProductCollectionFactory
     */
    protected ProductCollectionFactory $productCollectionFactory;

    /**
     * @var RequestInterface
     */
    protected RequestInterface $request;

    /**
     * @var array
     */
    protected $productTree;

    /**
     * @param ProductCollectionFactory $productCollectionFactory
     * @param RequestInterface $request
     */
    public function __construct(
        ProductCollectionFactory $productCollectionFactory,
        RequestInterface $request
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return $this->getCustomerTree();
    }

    /**
     * Retrieve categories tree
     *
     * @return array
     */
    protected function getCustomerTree()
    {
        if ($this->productTree === null) {




            $collection = $this->productCollectionFactory->create();
            $model = $collection->getData();

            foreach ($collection as $product) {
                $productId = (int) $product['entity_id'];
                if (!isset($productById[$productId])) {
                    $productById[$productId] = [
                        'value' => $productId
                    ];
                }
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $prd = $objectManager->create('Magento\Catalog\Model\Product')->load($productId);

                $productById[$productId]['label'] = $prd->getName();
            }

            $this->productTree = $productById ?? [];
        }
        return $this->productTree;
    }
}
