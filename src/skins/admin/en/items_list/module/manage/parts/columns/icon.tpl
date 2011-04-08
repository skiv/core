{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Modules list
 *
 * @author    Creative Development LLC <info@cdev.ru>
 * @copyright Copyright (c) 2011 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version   GIT: $Id$
 * @link      http://www.litecommerce.com/
 * @since     1.0.0
 * @ListChild (list="itemsList.module.manage.columns", weight="30")
 * @ListChild (list="itemsList.module.install.columns", weight="30")
 *}
<td class="icon">
  <a id="{module.getName()}"></a>
  <div class="icon-container">

    <div IF="!module.getEnabled()" class="addon-disabled">
      <img src="images/spacer.gif" class="disabled" alt="Disabled" />
    </div>

    <div class="addon-icon">
        <img IF="module.hasIcon()" src="{module.getIconURL()}" class="addon-icon" alt="{module.getName()}" />
        <img IF="!module.hasIcon()" src="images/spacer.gif" class="addon-icon addon-default-icon" alt="{module.getName()}" />
    </div>

 </div>
</td>

