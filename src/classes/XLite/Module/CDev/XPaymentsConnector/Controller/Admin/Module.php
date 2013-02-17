<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * LiteCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to licensing@litecommerce.com so we can send you a copy immediately.
 *
 * PHP version 5.3.0
 *
 * @category  LiteCommerce
 * @author    Creative Development LLC <info@cdev.ru>
 * @copyright Copyright (c) 2011-2012 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.litecommerce.com/
 */

namespace XLite\Module\CDev\XPaymentsConnector\Controller\Admin;

/**
 * Module settings
 *
 */
abstract class Module extends \XLite\Controller\Admin\Module implements \XLite\Base\IDecorator
{
    /**
     * Required fields
     *
     * @var array
     */
    protected $requiredFields = array(
        'store_id',
        'url',
        'public_key',
        'private_key',
        'private_key_password',
    );

    /**
     * Map fields
     *
     * @var array
     */
    protected $mapFields = array(
        'store_id'              => 'xpc_shopping_cart_id',
        'url'                   => 'xpc_xpayments_url',
        'public_key'            => 'xpc_public_key',
        'private_key'           => 'xpc_private_key',
        'private_key_password'  => 'xpc_private_key_password',
    );

    /**
     * Get configuration array from configuration deployement path
     *
     * @return array
     */
    public function getConfiguration()
    {
        return unserialize(base64_decode(\XLite\Core\Request::getInstance()->deploy_configuration));
    }

    /**
     * Check if the deploy configuration is correct array
     *
     * @param array $configuration Configuration array
     *
     * @return boolean
     */
    public function checkDeployConfiguration($configuration)
    {
        return is_array($configuration)
            && ($this->requiredFields === array_intersect(array_keys($configuration), $this->requiredFields));
    }

    /**
     * Store configuration array into DB
     *
     * @param array $configuration Configuration array
     *
     * @return void
     */
    public function setConfiguration($configuration)
    {
        foreach ($this->mapFields as $origName => $dbName) {
            $setting = \XLite\Core\Database::getRepo('XLite\Model\Config')
                ->findOneBy(array('name' => $dbName, 'category' => 'CDev\XPaymentsConnector'));

            \XLite\Core\Database::getRepo('XLite\Model\Config')->update(
                $setting,
                array('value' => $configuration[$origName])
            );
        }
    }

    /**
     * Check - has requested payment methods list or not
     *
     * @return boolean
     */
    public function hasPaymentMethodsList()
    {
        return 0 < count($this->getPaymentMethodsList());
    }

    /**
     * Get payment methods list
     *
     * @return array
     */
    public function getPaymentMethodsList()
    {
        return is_array(\XLite\Core\Session::getInstance()->xpc_payment_methods)
            ? \XLite\Core\Session::getInstance()->xpc_payment_methods
            : array();
    }

    /**
     * Check - can payment configuration specified transaction type
     *
     * @param array  $pm   Payment configuration
     * @param string $type Transaction type
     *
     * @return boolean
     */
    public function canTransactionType(array $pm, $type)
    {
        return isset($pm['transactionTypes'][$type])
            && $pm['transactionTypes'][$type];
    }

    /**
     * Payment configuration specified transaction type status
     *
     * @param mixed  $pm   Payment configuration
     * @param string $type Transaction type
     *
     * @return string
     */
    public function getTransactionTypeStatus($pm, $type)
    {
        $status = is_object($pm)
            ? $pm->getSetting($type)
            : $this->canTransactionType($pm, $type);

        return $status
            ? static::t('Yes')
            : static::t('No');
    }

    /**
     * Check - is payment configurations imported early or not
     *
     * @return boolean
     */
    public function isPaymentMethodsImported()
    {
        return 0 < count($this->getPaymentMethods());
    }

    /**
     * Get payment methods
     *
     * @return array
     */
    public function getPaymentMethods()
    {
        return \XLite\Core\Database::getRepo('XLite\Model\Payment\Method')
            ->findBy(array('class' => 'Module\CDev\XPaymentsConnector\Model\Payment\Processor\XPayments')); 
    }

    /**
     * Deploy configuration
     *
     * @return void
     */
    protected function doActionDeployConfiguration()
    {
        if (
            $this->getModuleID()
            && 'CDev\XPaymentsConnector' == $this->getModule()->getActualName()
        ) {
            $xpcConfig = $this->getConfiguration();

            if (true === $this->checkDeployConfiguration($xpcConfig)) {
                $this->setConfiguration($xpcConfig);
                \XLite\Core\TopMessage::addInfo('Configuration has been successfully deployed');

            } else {
                \XLite\Core\TopMessage::addError('Your configuration string is not correct');    
            }
        }
    }

    /**
     * Test module
     *
     * @return void
     */
    protected function doActionXpcTest()
    {
        if (
            $this->getModuleID()
            && 'CDev\XPaymentsConnector' == $this->getModule()->getActualName()
        ) {
            $result = \XLite\Module\CDev\XPaymentsConnector\Core\XPaymentsClient::getInstance()->requestTest();

            if (true === $result['status']) {
                \XLite\Core\TopMessage::addInfo('Test transaction completed successfully');

            } else {
                $message = false === $result['status']
                    ? $result['response']
                    : $result['response']['message'];

                \XLite\Core\TopMessage::addWarning(
                    'Test transaction failed. Please check the X-Payment Connector settings '
                    . 'and try again. If all options is ok review your X-Payments settings '
                    . 'and make sure you have properly defined shopping cart properties.'
                );
        
                if ($message) {
                    \XLite\Core\TopMessage::addError($message);
                }
            }
        }
    }

    /**
     * Request payment configurations
     *
     * @return void
     */
    protected function doActionXpcExport()
    {
        if (
            $this->getModuleID()
            && 'CDev\XPaymentsConnector' == $this->getModule()->getActualName()
        ) {
            \XLite\Core\Session::getInstance()->xpc_payment_methods = null;
            $list = \XLite\Module\CDev\XPaymentsConnector\Core\XPaymentsClient::getInstance()->requestPaymentMethods();
            if ($list) {
                \XLite\Core\Session::getInstance()->xpc_payment_methods = $list;

            } elseif (is_array($list)) {
                \XLite\Core\TopMessage::addWarning('There are no payment configurations for this store.');
            } else {
                \XLite\Core\TopMessage::addError(
                    'Error had occured during the requesting of payment methods from X-Payments. See log files for details.'
                );
            }

        }
    }

    /**
     * Clear requested payment configurations
     *
     * @return void
     */
    protected function doActionXpcClear()
    {
        if (
            $this->getModuleID()
            && 'CDev\XPaymentsConnector' == $this->getModule()->getActualName()
        ) {
            \XLite\Core\Session::getInstance()->xpc_payment_methods = null;
            $this->setReturnURL(
                $this->buildURL('module', null, array('moduleId' => $this->getModuleID()))
            );
        }
    }

    
    /**
     * Set payment method settings
     *
     * @param \XLite\Model\Payment\Method $pm       Payment method
     * @param array                       $settings Settings
     *
     * @return void
     */
    protected function setSettings(\XLite\Model\Payment\Method $pm, array $settings)
    {
        foreach ($settings as $k => $v) {
            if (is_array($v)) {
                $this->setSettings($pm, $v);
            } else {
                $pm->setSetting($k, $v);
            }
        }
    }

    /**
     * Import requested payment configurations
     *
     * @return void
     */
    protected function doActionXpcImport()
    {
        if (
            $this->getModuleID()
            && 'CDev\XPaymentsConnector' == $this->getModule()->getActualName()
        ) {
            $list = \XLite\Core\Session::getInstance()->xpc_payment_methods;
    
            if (!empty($list) && is_array($list)) {
                $result = true;
                if ($result) {
                    foreach ($this->getPaymentMethods() as $pm) {
                        \XLite\Core\Database::getEM()->remove($pm);
                    }
    
                    foreach ($list as $settings) {
                        $pm = new \XLite\Model\Payment\Method;
                        \XLite\Core\Database::getEM()->persist($pm);
                        $pm->setClass('Module\CDev\XPaymentsConnector\Model\Payment\Processor\XPayments');
                        $pm->setServiceName('XPayments.' . $settings['id']);
                        $pm->setName($settings['moduleName']);
                        $pm->setType(\XLite\Model\Payment\Method::TYPE_CC_GATEWAY);
                        $this->setSettings($pm, $settings);
                        $pm->setSetting('useLiteInterface', 'N');
                    }
    
                    \XLite\Core\Database::getEM()->flush();
                    \XLite\Core\Session::getInstance()->xpc_payment_methods = null;
    
                    \XLite\Core\TopMessage::getInstance()->addInfo('Payment methods have been successfully imported');
    
                } else {
                    \XLite\Core\TopMessage::addError(
                        'Error had occured during the requesting of payment methods from X-Payments. '
                        . 'See log files for details.'
                    );
                }
    
            } else {
                \XLite\Core\TopMessage::addError('There are no payment configurations for this store.');
            }
        }
    }

    /**
     * Update payment methods settings
     *
     * @return void
     */
    protected function doActionXpcSettings()
    {
        if (
            $this->getModuleID()
            && 'CDev\XPaymentsConnector' == $this->getModule()->getActualName()
        ) {
            $list = \XLite\Core\Request::getInstance()->list;

            if (!empty($list) && is_array($list)) {
                foreach ($this->getPaymentMethods() as $xpm) {
                    $xpm->setSetting(
                        'useLiteInterface', 
                        isset($list[$xpm->getMethodId()]) ? $list[$xpm->getMethodId()]['lite'] : 'N'
                    );
                }
                \XLite\Core\Database::getEM()->flush();
                \XLite\Core\TopMessage::getInstance()->addInfo('Data have been saved successfully');
            }
        }
    }

}