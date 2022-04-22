<?php
namespace Training\Blog\Block;

use Magento\Framework\App\ObjectManager;
use \Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Training\Blog\Model\Blog;
use Training\Blog\Model\BlogFactory;
use Training\Blog\Api\BlogRepositoryInterface;

class Index extends Template
{
    protected BlogFactory $_blogFactory;
    protected BlogRepositoryInterface $_blogRepository;
    protected TimezoneInterface $date;

    public function __construct(
        Context $context,
        BlogFactory $blogFactory,
        TimezoneInterface $date,
        BlogRepositoryInterface $blogRepository
    ) {
        $this->_blogFactory = $blogFactory;
        $this->_blogRepository = $blogRepository;
        $this->date = $date;
        parent::__construct($context);
    }

    public function getBlogCollection($category_id, $page, $keyword, $perPage){
        $blogs = $this->getBlog($category_id, $keyword);

        return $blogs->setPageSize($perPage ?? 5)->setCurPage($page ?? 1);
    }

    public function listBlog() {
        $test = $this->_blogRepository->getList();
        $category_id = $this->getRequest()->getParam('category_id');
        $page = $this->getRequest()->getParam('page');
        $keyword = $this->getRequest()->getParam('keyword');
        $perPage = $this->getRequest()->getParam('per_page') ?? 5;

        $response = [];

        $response['blogs'] = $this->getBlogCollection($category_id, $page, $keyword, $perPage)->getData();
        $response['categories'] = $this->getCategories();
        $response['last_page'] = (int) $this->getPage($category_id, $keyword, $perPage);

        return $response;
    }

    public function getBlog($category_id, $keyword) {
        $blog = $this->_blogFactory->create();
        $collection = $blog->getCollection();

        $blogs =  $collection;
        if (isset($category_id)) {
            $blogs = $blogs->join(
                ['category_blog' => 'category_blog'],
                'category_blog.blog_id= main_table.blog_id',
                ['']
            )->addFieldToFilter('category_blog.category_id', ['eq' => (int) $category_id]);
        }

        if (isset($keyword)) {
            $blogs = $blogs->addFieldToFilter('name', ['like' => '%' . $keyword . '%']);
        }

        $blogs = $blogs->addFieldToFilter('status', ['eq' => Blog::STATUS_ENABLED]);

        $now = new \DateTime();
        $blogs = $blogs->addFieldToFilter('publish_date_from', ['lteq' => $now]);
        return $blogs->addFieldToFilter('publish_date_to', ['gteq' => $now]);
    }

    public function getCategories()
    {
        $objectManager = ObjectManager::getInstance();
        $model = $objectManager->create('Training\Blog\Model\Category');
        $category = $model->getCollection()->getData();
        $categories = [];
        $this->getChild($categories, $category);

        return $categories;
    }

    private function getChild(&$arr, $categories, $parentId = "0", $level = 0)
    {
        foreach ($categories as $key => $category) {
            if ($category['parent_id'] === $parentId) {
                $arr[$key] = [
                    'value' => (int) $category['category_id'],
                    'label' => $category['name'],
                    'level' => $level,
                ];
                unset($categories[$key]);
                $this->getChild($arr, $categories, $category['category_id'], $level + 1);
            }
        }
    }

    public function getPage($category_id, $keyword, $perPage) {
        $blogs = $this->getBlog($category_id, $keyword);

        return ceil(count($blogs->getData()) / (int) $perPage);
    }

    public function getLink($category_id, $page, $keyword, $perPage) {
        $link = '';
        if (isset($category_id)) $link .= '&category_id=' . $category_id;
        if (isset($page)) $link .= '&page=' . $page;
        if (isset($keyword)) $link .= '&keyword=' . $keyword;
        if (isset($perPage)) $link .= '&per_page=' . $perPage;
        $link = substr($link, 1);

        return '/blog?' . $link;
    }
}
