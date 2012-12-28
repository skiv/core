{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Body
 *
 * @author    Creative Development LLC <info@cdev.ru>
 * @copyright Copyright (c) 2011-2012 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.litecommerce.com/
 *}
<div class="add-to-compare">
  <div class="compare-popup{if:isEmptyList()} hidden{end:}">
    <div class="compare-checkbox">
      <input id="{getCheckboxId(product.product_id)}" type="checkbox" data-id="{product.product_id}"{if:isChecked(product.product_id)} checked="checked"{end:} />
      <label for="{getCheckboxId(product.product_id)}">{t(#Add to compare#)}</label>
    </div>
    <div class="compare-button">
      <span class="compare-products-selected">{getTitle()}</span>
      <widget class="\XLite\Module\CDev\ProductComparison\View\Button\Compare" location="{buildURL(#compare#)}" />
    </div>
  </div>
</div>
