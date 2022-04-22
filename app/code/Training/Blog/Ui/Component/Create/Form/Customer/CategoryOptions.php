<?php
namespace Training\Blog\Ui\Component\Create\Form\Customer;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\App\RequestInterface;
use Training\Blog\Helper\Helper;

/**
 * Options tree for "Categories" field
 */
class CategoryOptions implements OptionSourceInterface
{
    /**
     * @var RequestInterface
     */
    protected RequestInterface $request;

    /**
     * @var array
     */
    protected $productTree;

    protected Helper $_helper;

    /**
     * @param RequestInterface $request
     * @param Helper $helper
     */
    public function __construct(
        RequestInterface $request,
        Helper $helper
    ) {
        $this->request = $request;
        $this->_helper = $helper;
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
        $objectManager = ObjectManager::getInstance();
        $model = $objectManager->create('Training\Blog\Model\Category');
        $category = $model->getCollection()->getData();
        $categories = [];
        $this->_helper->getCategories($categories, $category);

        return $categories;
    }
}
