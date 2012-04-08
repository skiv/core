{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * ____file_title____
 *
 * @author    Creative Development LLC <info@cdev.ru>
 * @copyright Copyright (c) 2011 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.litecommerce.com/
 * @since     1.0.0
 *}
<html>
<body>
{t(#Dear X#,_ARRAY_(#firstname#^order.profile.billing_address.firstname,#lastname#^order.profile.billing_address.lastname)):h}
<p>
{t(#Your order has been processed#,_ARRAY_(#id#^order.order_id)):h} {t(#Thank you for your order FOOTER#):h}
<p>
<widget class="\XLite\View\Invoice" order="{order}" />
<p>
{signature:h}
</body>
</html>
