<?php
namespace Training\Blog\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

//        if (!$installer->tableExists('posts')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('blogs')
                )
                ->addColumn(
                    'blog_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true]
                )
                ->addColumn(
                    'name',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false, 'default' => '']
                )
                ->addColumn(
                    'short_description',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false, 'default' => '']
                )
                ->addColumn(
                    'description',
                    Table::TYPE_TEXT,
                    '64k',
                    ['nullable' => false, 'default' => '']
                )
                ->addColumn(
                    'status',
                    Table::TYPE_SMALLINT,
                    1,
                    ['nullable' => false, 'default' => 1]
                )
                ->addColumn(
                    'thumbnail',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false, 'default' => '']
                )
                ->addColumn(
                    'gallery',
                    Table::TYPE_TEXT,
                    '64k',
                    ['nullable' => false, 'default' => '']
                )
                ->addColumn(
                    'publish_date_from',
                    Table::TYPE_DATETIME,
                    null,
                    ['nullable' => false]
                )
                ->addColumn(
                    'publish_date_to',
                    Table::TYPE_DATETIME,
                    null,
                    ['nullable' => false]
                )
                ->addColumn(
                    'categories',
                    Table::TYPE_TEXT,
                    '64k',
                    ['nullable' => true]
                )
                ->addColumn(
                    'tags',
                    Table::TYPE_TEXT,
                    '64k',
                    ['nullable' => true]
                )
                ->addColumn(
                    'url_key',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true]
                )
                ->addColumn(
                    'product_ids',
                    Table::TYPE_TEXT,
                    '64k',
                    ['nullable' => true]
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                )->addColumn(
                    'updated_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                )
                ->setComment('Create Posts Table');

            $installer->getConnection()->createTable($table);
//        }

//        if (!$installer->tableExists('categories')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('categories')
                )
                ->addColumn(
                    'category_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true]
                )
                ->addColumn(
                    'name',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false, 'default' => '']
                )
                ->addColumn(
                    'parent_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false, 'default' => 0]
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                )
                ->addColumn(
                    'updated_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                )
                ->setComment('Create Categories Table');

            $installer->getConnection()->createTable($table);
//        }

        //        if (!$installer->tableExists('category_blog')) {
        $table = $installer->getConnection()->newTable(
            $installer->getTable('category_blog')
            )
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true]
            )
            ->addColumn(
                'category_id',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false]
            )
            ->addColumn(
                'blog_id',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false]
            )
            ->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            )
            ->addColumn(
                'updated_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
            )
            ->setComment('Create Categories Table');

            $installer->getConnection()->createTable($table);
//        }

//        if (!$installer->tableExists('tags')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('tags')
                )
                ->addColumn(
                    'tag_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true]
                )
                ->addColumn(
                    'name',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false, 'default' => '']
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                )
                ->addColumn(
                    'updated_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                )
                ->setComment('Create Categories Table');

            $installer->getConnection()->createTable($table);
//        }

        //        if (!$installer->tableExists('categories')) {
        $table = $installer->getConnection()->newTable(
            $installer->getTable('tag_blog')
            )
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true]
            )
            ->addColumn(
                'tag_id',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false]
            )
            ->addColumn(
                'blog_id',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false]
            )
            ->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            )
            ->addColumn(
                'updated_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
            )
            ->setComment('Create Categories Table');

        $installer->getConnection()->createTable($table);
//        }

        $installer->endSetup();
    }
}
