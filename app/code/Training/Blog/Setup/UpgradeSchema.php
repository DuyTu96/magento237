<?php
namespace Training\Blog\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{

    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $connection = $setup->getConnection();
        $tableName = $setup->getTable('blogs');
//        $connection->addIndex(
//            $tableName,
//            'search',
//            [
//                'name',
//            ],
//            AdapterInterface::INDEX_TYPE_FULLTEXT
//        );

        $connection->addIndex(
            $tableName,
            'name',
            [
                'name'
            ],
            AdapterInterface::INDEX_TYPE_FULLTEXT //type of index
        );

        $setup->endSetup();
    }
}
