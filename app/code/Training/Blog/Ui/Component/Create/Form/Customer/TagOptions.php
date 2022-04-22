<?php
namespace Training\Blog\Ui\Component\Create\Form\Customer;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\App\RequestInterface;

/**
 * Options tree for "Categories" field
 */
class TagOptions implements OptionSourceInterface
{
    /**
     * @var RequestInterface
     */
    protected RequestInterface $request;

    /**
     * @var array
     */
    protected $productTree;

    /**
     * @param RequestInterface $request
     */
    public function __construct(
        RequestInterface $request
    ) {
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
        $objectManager = ObjectManager::getInstance();
        $model = $objectManager->create('Training\Blog\Model\Tag');
        $data = $model->getCollection()->getData();

        $cats = [];
        $this->getChild($cats, $data);

        return $cats;
    }

    private function getChild(&$arr, $tags)
    {
        foreach ($tags as $key => $tag) {
            $arr[$key] = [
                'value' => (int) $tag['tag_id'],
                'label' => $tag['name']
            ];
            unset($tags[$key]);
        }
    }
}
