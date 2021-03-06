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
 * @since     1.0.18
 */

namespace XLite\View;

/**
 * Low inventory box
 * 
 * @see   ____class_see____
 * @since 1.0.18
 *
 * @ListChild (list="main", weight="200", zone="admin")
 */
class LowInventoryBox extends \XLite\View\AView
{

    /**
     * Return widget default template
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getDefaultTemplate()
    {
        return 'main/parts/low_inventory.tpl';
    }

    /**
     * Check ACL permissions
     *
     * @return boolean
     * @see    ____func_see____
     * @since  1.0.17
     */
    protected function checkACL()
    {
        $auth = \XLite\Core\Auth::getInstance();

        return parent::checkACL()
            && ($auth->isPermissionAllowed(\XLite\Model\Role\Permission::ROOT_ACCESS) || $auth->isPermissionAllowed('manage catalog'));
    }
}

