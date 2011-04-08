{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * ____file_title____
 *  
 * @author    Creative Development LLC <info@cdev.ru> 
 * @copyright Copyright (c) 2011 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version   GIT: $Id$
 * @link      http://www.litecommerce.com/
 * @since     1.0.0
 *}

<div class="sort-order">
  {if:isSortByModeSelected(sortByColumn)}
    <div class="part order-by"><a href="{getActionURL(_ARRAY_(%static::PARAM_SORT_ORDER%^getSortOrderToChange()))}"><span class="selected">{title:h}</span></a>&nbsp;{if:isSortOrderAsc()}&darr;{else:}&uarr;{end:}</div>
  {else:}
    <div class="part sort-crit"><a class="{sortByColumn}" href="{getActionURL(_ARRAY_(%static::PARAM_SORT_BY%^sortByColumn))}">{title:h}</a></div>
  {end:}
</div>
