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
 * @copyright Copyright (c) 2011 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.litecommerce.com/
 * @see       ____file_see____
 * @since     1.0.0
 */

namespace XLite\View\Button;


/**
 * Delete address button widget
 *
 * @see   ____class_see____
 * @since 1.0.0
 */
class DeleteAddress extends \XLite\View\Button\Regular
{
    /*
     * Address identificator parameter
     */
    const PARAM_ADDRESS_ID = 'addressId';

    /**
     * getJSFiles
     *
     * @return array
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'button/js/delete_address.js';

        return $list;
    }

    /**
     * Register CSS files for delete address button
     *
     * @return array
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'button/css/delete_address.css';

        return $list;
    }

    /**
     * Define widget params
     *
     * @return void
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            self::PARAM_ADDRESS_ID => new \XLite\Model\WidgetParam\Int('Address ID', 0),
        );
    }

    /**
     * Return JS parameters
     *
     * @return array
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getJSParams()
    {
        return array(
            'address_id'    => $this->getParam(self::PARAM_ADDRESS_ID),
            'warning_text'  => static::t('Delete this address?'),
        );
    }

    /**
     * Return widget default template
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getDefaultTemplate()
    {
        return 'button/delete_address.tpl';
    }

    /**
     * Return CSS classes
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getClass()
    {
        return 'delete-address ' . ($this->getParam(self::PARAM_STYLE) ?: '');
    }

}
