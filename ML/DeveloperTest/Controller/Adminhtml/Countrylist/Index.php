<?php

namespace ML\DeveloperTest\Controller\Adminhtml\Countrylist;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action as BackendAction;

/**
 * Class Index
 * @package ML\DeveloperTest\Controller\Adminhtml\Countrylist
 * @author Kashif <kash@dreamsites.co.uk>
 */
class Index extends BackendAction
{

    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $_resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $_resultPageFactory
    )
    {
        parent::__construct($context);
        $this->_resultPageFactory = $_resultPageFactory;
    }

    /**
     * Check the permission to run it
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('ML_DeveloperTest::countrylist');
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('ML_DeveloperTest::countrylist');
        $resultPage->addBreadcrumb(__('ML'), __('ML'));
        $resultPage->addBreadcrumb(__('Countries Allowed'), __('Countries Allowed'));
        $resultPage->getConfig()->getTitle()->prepend(__('Countries Allowed To Order'));

        return $resultPage;
    }
}
