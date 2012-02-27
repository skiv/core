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
 * @since     1.0.14
 */

namespace XLite\View\Attributes\Book\Row;

/**
 * Group
 *
 * @see   ____class_see____
 * @since 1.0.14
 */
class Group extends \XLite\View\NestedDraggableRows\Row\ARow
{
    /**
     * Widget param names
     */
    const PARAM_GROUP = 'group';
    const PARAM_ATTRS = 'attributes';

    /**
     * Return row identifier
     *
     * @return void
     * @see    ____func_see____
     * @since  1.0.14
     */
    public function getRowUniqueId()
    {
        return $this->getGroup()->getId() ?: '_';
    }

    /**
     * Return CSS class for the row
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.16
     */
    public function getRowCSSClass()
    {
        return 'level-1';
    }

    /**
     * Check if it's the nested row
     *
     * @return boolean
     * @see    ____func_see____
     * @since  1.0.15
     */
    public function isNestedRow()
    {
        return true;
    }

    /**
     * Alias
     *
     * @return array
     * @see    ____func_see____
     * @since  1.0.16
     */
    public function getNestedWidgets()
    {
        return $this->getParam(static::PARAM_ATTRS);
    }

    /**
     * Return widget template path
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.14
     */
    protected function getDefaultTemplate()
    {
        return 'attributes/book/row/group/body.tpl';
    }

    /**
     * Return name of the "position" field
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.14
     */
    protected function getRowPosFieldName()
    {
        return 'pos';
    }

    /**
     * Return value of the "position" field
     *
     * @return integer
     * @see    ____func_see____
     * @since  1.0.14
     */
    protected function getRowPosFieldValue()
    {
        return $this->getGroup()->getPos();
    }

    /**
     * Define widget params
     *
     * @return void
     * @see    ____func_see____
     * @since  1.0.14
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_GROUP => new \XLite\Model\WidgetParam\Object(
                'Group object', new \XLite\Model\Attribute\Group(), false, '\XLite\Model\Attribute\Group'
            ),
            static::PARAM_ATTRS => new \XLite\Model\WidgetParam\Collection(
                'Group attributes', array()
            ),
        );
    }

    /**
     * Alias
     *
     * @return \XLite\Model\Attribute\Group
     * @see    ____func_see____
     * @since  1.0.14
     */
    protected function getGroup()
    {
        return $this->getParam(static::PARAM_GROUP);
    }

    /**
     * Alias
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.14
     */
    protected function getGroupTitle()
    {
        return $this->getGroup()->getTitle();
    }

    /**
     * Alias
     *
     * @return integer
     * @see    ____func_see____
     * @since  1.0.14
     */
    protected function getGroupAttributesNumber()
    {
        return count($this->getNestedWidgets());
    }
}
