<?php

namespace Training\Blog\Ui\Component\Form\Element;

class InputDate extends \Magento\Ui\Component\Form\Element\Input
{
    /**
     * Prepare component configuration
     *
     * @return void
     */
    public function prepare()
    {
        parent::prepare();

        $config = $this->getData('config');

        if(isset($config['dataScope']) && $config['dataScope']=='publish_date_from'){
            $config['default']= date('Y-m-d', strtotime('+0 years'));
            $this->setData('config', (array)$config);
        }
        if(isset($config['dataScope']) && $config['dataScope']=='publish_date_to'){
            $config['default']= date('Y-m-d', strtotime('+1 years'));
            $this->setData('config', (array)$config);
        }
    }
}
