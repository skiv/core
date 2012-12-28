{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Body
 *
 * @author    Creative Development LLC <info@cdev.ru>
 * @copyright Copyright (c) 2011-2012 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.litecommerce.com/
 *}
<div class="product-comparison">
  <div IF="!isEmptyList()" class="block block-block">
    <h2>{t(getHead())}</h2>
    <ul>
      {foreach:getProducts(),product}
        <li>
          <a href="#" class="remove" title="{t(#Remove#)}" data-id="{product.product_id}"><img src="images/spacer.gif" alt="{t(#Remove#)}" /></a>
          <a href="{product.getURL()}">{product.getName()}</a>
        </li>
      {end:}
    </ul>
    <widget class="\XLite\Module\CDev\ProductComparison\View\Button\Compare" location="{buildURL(#compare#)}" />
    <a href="#" class="clear-list">{t(#Clear list#)}</a>
  </div>
</div>
