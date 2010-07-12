{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * ____file_title____
 *
 * @author    Creative Development LLC <info@cdev.ru>
 * @copyright Copyright (c) 2010 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version   SVN: $Id$
 * @link      http://www.litecommerce.com/
 * @since     3.0.0
 *}
The form below allows you to create a partner profile. Do not forget that this information is essential to use our services correctly. Mandatory fields are marked with an asterisk (<font class="Star">*</font>). 

<p IF="userExists" class="ErrorMessage">&gt;&gt;&nbsp;The user is already registered! Please select another e-mail.&nbsp;&lt;&lt;</p>
<p IF="invalidPassword" class="ErrorMessage">&gt;&gt;&nbsp;Invalid login or password.&nbsp;&lt;&lt;</p>
<p IF="!valid" class=ErrorMessage>&gt;&gt;&nbsp;There are errors in the form. Please fill all required fields!&nbsp;&lt;&lt;</p>

<form action="cart.php" method=POST name="registration_form">
<input type="hidden" foreach="allparams,param,v" name="{param}" value="{v}"/>
<input type="hidden" name="action" value="{mode}">
<input type="hidden" name="parent" value="{parent}">

<table border=0 cellspacing=0 cellpadding=2>
<tr valign="middle">
    <td width=150><img src="images/spacer.gif" width=1 height=1 border=0 alt=""></td>
    <td width=10><img src="images/spacer.gif" width=1 height=1 border=0 alt=""></td>
    <td width=150><img src="images/spacer.gif" width=1 height=1 border=0 alt=""></td>
    <td><img src="images/spacer.gif" width=1 height=1 border=0 alt=""></td>
</tr>
<tr valign="middle">
    <td colspan="4"><b>E-mail &amp; Password</b><br><hr size="1" noshade></td>
</tr>
<tr valign="middle">
    <td align="right">E-mail</td>
    <td width="10"><font color="red">*</font></td>
    <td width="150">
        <input type="text" name="login" value="{login:r}" size="32" maxlength="128">
    </td>
    <td>
        &nbsp;
        <widget class="\XLite\Validator\EmailValidator" field="login">
    </td>
</tr>
<tr valign="middle">
    <td align="right">Password</td>
    <td><font class=Star>*</font></td>
    <td>
        <input type="password" name="password" value="{password:r}" size="32" maxlength="128">
    </td>
    <td>
        &nbsp;
        <widget class="\XLite\Validator\RequiredValidator" field="password">
    </td>
</tr>
<tbody IF="!auth.logged">
<tr valign="middle">
    <td align="right">Confirm password</td>
    <td><font class=Star>*</font></td>
    <td>
        <input type="password" name="confirm_password" value="{confirm_password:r}" size="32" maxlength="128">
    </td>
    <td>
        &nbsp;
        <widget class="\XLite\Validator\RequiredValidator" field="confirm_password">
        <widget class="\XLite\Validator\PasswordValidator" field="confirm_password" passwordField="password">
    </td>
</tr>
<tr valign="middle">
    <td align="right">Password hint</td>
    <td>{if:config.Miscellaneous.partner_profile.password_hint}<font class=Star>*</font>{else:}&nbsp;{end:}</td>
    <td>
        <input type="text" name="password_hint" value="{password_hint:r}" size="32" maxlength="128">
    </td>
    <td>
        &nbsp;
        <widget class="\XLite\Validator\RequiredValidator" field="password_hint" visible="{config.Miscellaneous.partner_profile.password_hint}">
    </td>
</tr>
<tr valign="middle">
    <td align="right">Password hint answer</td>
    <td>{if:config.Miscellaneous.partner_profile.password_hint_answer}<font class=Star>*</font>{else:}&nbsp;{end:}</td>
    <td>
        <input type="text" name="password_hint_answer" value="{password_hint_answer:r}" size="32" maxlength="128">
    </td>
    <td>
        &nbsp;
        <widget class="\XLite\Validator\RequiredValidator" field="password_hint_answer" visible="{config.Miscellaneous.partner_profile.password_hint_answer}">
    </td>
</tr>
</tbody>

<tbody>
<tr>
    <td colspan="4">&nbsp;</td>
</tr>

<!-- ********************************* BILLING ADDRESS ********************************* -->

<tr valign="middle">
    <td colspan="4"><b>Billing information</b><br><hr size="1" noshade></td>
</tr>
<tr valign="middle">
    <td align="right">Title</td>
    <td>&nbsp;</td>
    <td>
        <select name="billing_title">
            <option value="Mr." selected="{billing_title=#Mr.#}">Mr.</option>
            <option value="Mrs." selected="{billing_title=#Mrs.#}">Mrs.</option>
            <option value="Ms." selected="{billing_title=#Ms.#}">Ms.</option>
        </select>
    </td>
    <td>&nbsp;</td>
</tr>
<tr valign="middle">
    <td align="right">First Name</td>
    <td>{if:config.Miscellaneous.partner_profile.billing_firstname}<font color="red">*</font>{else:}&nbsp;{end:}</td>
    <td>
        <input type="text" name="billing_firstname" value="{billing_firstname:r}" size="32" maxlength="128">
    </td>
    <td>
        &nbsp;
        <widget class="\XLite\Validator\RequiredValidator" field="billing_firstname" visible="{config.Miscellaneous.partner_profile.billing_firstname}">
    </td>
</tr>
<tr valign="middle">
    <td align="right">Last Name</td>
    <td>{if:config.Miscellaneous.partner_profile.billing_lastname}<font color="red">*</font>{else:}&nbsp;{end:}</td>
    <td>
        <input type="text" name="billing_lastname" value="{billing_lastname:r}" size="32" maxlength="128">
    </td>
    <td align="left">
        &nbsp;
        <widget class="\XLite\Validator\RequiredValidator" field="billing_lastname" visible="{config.Miscellaneous.partner_profile.billing_lastname}">
    </td>
</tr>
<tr valign="middle">
    <td align="right">Company</td>
    <td>{if:config.Miscellaneous.partner_profile.billing_company}<font  color="red">*</font>{else:}&nbsp;{end:}</td>
    <td>
        <input type="text" name="billing_company" value="{billing_company:r}" size="32" maxlength="255">
    </td>
    <td>
        &nbsp;
        <widget class="\XLite\Validator\RequiredValidator" field="billing_company" visible="{config.Miscellaneous.partner_profile.billing_company}">
    </td>
</tr>
<tr valign="middle">
    <td align="right">Phone</td>
    <td>{if:config.Miscellaneous.partner_profile.billing_phone}<font color="red">*</font>{else:}&nbsp;{end:}</td>
    <td>
        <input type="text" name="billing_phone" value="{billing_phone:r}" size="32" maxlength="32">
    </td>
    <td>
        &nbsp;
        <widget class="\XLite\Validator\RequiredValidator" field="billing_phone" visible="{config.Miscellaneous.partner_profile.billing_phone}">
    </td>
</tr>
<tr valign="middle">
    <td align="right">Fax</td>
    <td>{if:config.Miscellaneous.partner_profile.billing_fax}<font color="red">*</font>{else:}&nbsp;{end:}</td>
    <td>
        <input type="text" name="billing_fax" value="{billing_fax:r}" size="32" maxlength="32">
    </td>
    <td>
        &nbsp;
        <widget class="\XLite\Validator\RequiredValidator" field="billing_fax" visible="{config.Miscellaneous.partner_profile.billing_fax}">
    </td>
</tr>
<tr valign="middle">
    <td align="right">Address</td>
    <td>{if:config.Miscellaneous.partner_profile.billing_address}<font color="red">*</font>{else:}&nbsp;{end:}</td>
    <td>
        <input type="text" name="billing_address" value="{billing_address:r}" size="32" maxlength="64">
    </td>
    <td>
        &nbsp;
        <widget class="\XLite\Validator\RequiredValidator" field="billing_address" visible="{config.Miscellaneous.partner_profile.billing_address}">
    </td>
</tr>
<tr valign="middle">
    <td align="right">City</td>
    <td>{if:config.Miscellaneous.partner_profile.billing_city}<font color="red">*</font>{else:}&nbsp;{end:}</td>
    <td>
        <input type="text" name="billing_city" value="{billing_city:r}" size="32" maxlength="64">
    </td>
    <td>
        &nbsp;
        <widget class="\XLite\Validator\RequiredValidator" field="billing_city" visible="{config.Miscellaneous.partner_profile.billing_city}">
    </td>
</tr>
<tr valign="middle">
    <td align="right">State</td>
    <td>{if:config.Miscellaneous.partner_profile.billing_state}<font color="red">*</font>{else:}&nbsp;{end:}</td>
    <td>
		<widget class="\XLite\View\StateSelect" field="billing_state" state="{billing_state}" isLinked=1 />
    </td>
    <td>
        &nbsp;
        <widget class="\XLite\Validator\RequiredValidator" field="billing_state" visible="{config.Miscellaneous.partner_profile.billing_state}">
        <widget class="\XLite\Validator\StateValidator" field="billing_state" countryField="billing_country" visible="{config.Miscellaneous.partner_profile.billing_state}">
    </td>
</tr>
<tr valign="middle">
    <td align="right">Country</td>
    <td>{if:config.Miscellaneous.partner_profile.billing_country}<font color="red">*</font>{else:}&nbsp;{end:}</td>
    <td>
		<widget class="\XLite\View\CountrySelect" field="billing_country" fieldId="xx2">
    </td>
    <td>
        &nbsp;
        <widget class="\XLite\Validator\RequiredValidator" field="billing_country" IF="{config.Miscellaneous.partner_profile.billing_country}" country="{billing_country}" />
    </td>
</tr>
<tr valign="middle">
    <td align="right">Zip code</td>
    <td>{if:config.Miscellaneous.partner_profile.billing_zipcode}<font color="red">*</font>{else:}&nbsp;{end:}</td>
    <td nowrap>
        <input type="text" name="billing_zipcode" value="{billing_zipcode:r}" size="32" maxlength="32">
    </td>
    <td>
        &nbsp;
        <widget class="\XLite\Validator\RequiredValidator" field="billing_zipcode" visible="{config.Miscellaneous.partner_profile.billing_zipcode}">
    </td>
</tr>

<tr>
    <td colspan="4">&nbsp;</td>
</tr>

{*extraFields*}

<tr valign="middle">
    <td colspan="4"><b>Partner information</b><br><hr size="1" noshade></td>
</tr>
<tr valign="middle">
    <td align="right">Signup for partner plan</td>
    <td class=Star>*</td>
    <td>
        <select class="FixedSelect" name="pending_plan">
            <option value="" selected="{pending_plan=##}">Select one..</option>
            <span FOREACH="xlite.factory.\XLite\Module\Affiliate\Model\AffiliatePlan.findAll(),ap">
            <span IF="ap.plan_id=config.Affiliate.default_plan">
            <option value="{ap.plan_id}" selected="{ap.plan_id=pending_plan}">{ap.title:h} (default)</option>
            </span>
            <span IF="!ap.plan_id=config.Affiliate.default_plan">
            <option value="{ap.plan_id}" selected="{ap.plan_id=pending_plan}">{ap.title:h}</option>
            </span>
            </span>
        </select>
    </td>
    <td>&nbsp;
        <widget class="\XLite\Validator\RequiredValidator" field="pending_plan"> 
    </td>
</tr>

<!-- ********************************* ADDITIONAL FIELDS ********************************* -->

<widget class="\XLite\Module\Affiliate\View\PartnerField" template="modules/Affiliate/partner_field.tpl" formField="partner_fields" partnerFields="{partnerFields}">

</table>

<br>
<div>
<widget template="common/spambot_arrest.tpl" id="on_partner_register"></div>

<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr valign="middle">
    <td width="160">&nbsp;</td>
    <td >
        By clicking "SUBMIT" you agree with our <a href="cart.php?target=help&amp;mode=terms_conditions" style="TEXT-DECORATION: underline" target="_blank">Terms &amp; Conditions.</a><br>
        <br>
        <a href="javascript: document.registration_form.submit()"><input type="image" src="images/go.gif" style="width: 13px; height: 13px; border: none;" align="left"><font class="FormButton"> Submit</font></a><br>
    </td>
</tr>
</table>
</form>
