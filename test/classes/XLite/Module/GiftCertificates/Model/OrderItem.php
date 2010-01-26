<?php
/*
+------------------------------------------------------------------------------+
| LiteCommerce                                                                 |
| Copyright (c) 2003-2009 Creative Development <info@creativedevelopment.biz>  |
| All rights reserved.                                                         |
+------------------------------------------------------------------------------+
| PLEASE READ  THE FULL TEXT OF SOFTWARE LICENSE AGREEMENT IN THE  "COPYRIGHT" |
| FILE PROVIDED WITH THIS DISTRIBUTION.  THE AGREEMENT TEXT  IS ALSO AVAILABLE |
| AT THE FOLLOWING URLs:                                                       |
|                                                                              |
| FOR LITECOMMERCE                                                             |
| http://www.litecommerce.com/software_license_agreement.html                  |
|                                                                              |
| FOR LITECOMMERCE ASP EDITION                                                 |
| http://www.litecommerce.com/software_license_agreement_asp.html              |
|                                                                              |
| THIS  AGREEMENT EXPRESSES THE TERMS AND CONDITIONS ON WHICH YOU MAY USE THIS |
| SOFTWARE PROGRAM AND ASSOCIATED DOCUMENTATION THAT CREATIVE DEVELOPMENT, LLC |
| REGISTERED IN ULYANOVSK, RUSSIAN FEDERATION (hereinafter referred to as "THE |
| AUTHOR")  IS  FURNISHING  OR MAKING AVAILABLE TO  YOU  WITH  THIS  AGREEMENT |
| (COLLECTIVELY,  THE "SOFTWARE"). PLEASE REVIEW THE TERMS AND  CONDITIONS  OF |
| THIS LICENSE AGREEMENT CAREFULLY BEFORE INSTALLING OR USING THE SOFTWARE. BY |
| INSTALLING,  COPYING OR OTHERWISE USING THE SOFTWARE, YOU AND  YOUR  COMPANY |
| (COLLECTIVELY,  "YOU")  ARE ACCEPTING AND AGREEING  TO  THE  TERMS  OF  THIS |
| LICENSE AGREEMENT. IF YOU ARE NOT WILLING TO BE BOUND BY THIS AGREEMENT,  DO |
| NOT  INSTALL  OR USE THE SOFTWARE. VARIOUS COPYRIGHTS AND OTHER INTELLECTUAL |
| PROPERTY  RIGHTS PROTECT THE SOFTWARE. THIS AGREEMENT IS A LICENSE AGREEMENT |
| THAT  GIVES YOU LIMITED RIGHTS TO USE THE SOFTWARE AND NOT AN AGREEMENT  FOR |
| SALE  OR  FOR TRANSFER OF TITLE. THE AUTHOR RETAINS ALL RIGHTS NOT EXPRESSLY |
|                                                                              |
| The Initial Developer of the Original Code is Creative Development LLC       |
| Portions created by Creative Development LLC are Copyright (C) 2003 Creative |
| Development LLC. All Rights Reserved.                                        |
+------------------------------------------------------------------------------+
*/

/* vim: set expandtab tabstop=4 softtabstop=4 foldmethod=marker shiftwidth=4: */

/**
* Module_GiftCertificates_OrderItem description.
*
* @package Module_GiftCertificates
* @access public
* @version $Id$
*/
class XLite_Module_GiftCertificates_Model_OrderItem extends XLite_Model_OrderItem implements XLite_Base_IDecorator
{	
    protected $gc = null;

    public function __construct()
    {
		$this->fields["gcid"] = ""; // Gift Certificate unique ID
        parent::__construct();
    }

	function getGC()
	{
        if (is_null($this->gc)) {
            if (parent::get("gcid")) {
                $this->gc = new XLite_Module_GiftCertificates_Model_GiftCertificate(parent::get("gcid"));
            } else {
                $this->gc = null;
            }
        }
        return $this->gc;
	}

	function getKey()
	{
		if ($this->get("gcid")) {
			return "GC".$this->get("gcid");
		} else {
			return parent::getKey();
		}
	}
	function getTaxableTotal()
	{
		if (!is_null($this->getGC())) {
			return 0;
		}
		return parent::getTaxableTotal();
	}
    function isShipped()
    {
		if (!is_null($this->getGC())) {
	        return false;
		}
		return parent::isShipped();
    }
	function getDescription()
	{
		if (!is_null($this->getGC())) { 
			return "Gift certificate # ".$this->get("gcid");
		}
		return parent::getDescription();
	}
    function getDiscountablePrice()
    {
        return is_null($this->getGC()) ? parent::getDiscountablePrice() : 0;
    }
	function getShortDescription($limit = 30)
	{
		if (!is_null($this->getGC())) { 
			return "GC #".$this->get("gcid");
		}
		return parent::getShortDescription($limit);
	}
	function get($name)
	{
		if (!is_null($this->getGC())) {
			if ($name == 'name')   return $this->getDescription();
			if ($name == 'brief_description') return $this->getDescription();
			if ($name == 'description') return $this->getDescription();
			if ($name == 'sku')   return "";
            if ($name == 'amount') return 1;
		}
		return parent::get($name);
	}

	function delete()
	{
		// remove disabled GCs
		if (!is_null($this->getGC()) && $this->getGC()->get('status') == "D") {
			$this->getGC()->delete();
		}
		parent::delete();
	}

	function isValid()
	{
        $gc = $this->getGC();
		if (!is_null($gc)) {
			return $this->getGC()->is('exists');
		}
		return parent::isValid();
	}
					
	function setGC($gc)
	{
		$this->gc = $gc;
        if (is_null($gc)) {
            $this->set("gcid", "");
        } else {
            $this->set("gcid", $gc->get("gcid"));
            $this->set("product_id", "");
            $this->set("price", $gc->get("amount"));
        }
	}

    function hasOptions()
    {
        // check if the ProductOptions module is on
        if (is_null($this->xlite->getComplex('mm.activeModules.ProductOptions'))) {
            return false;
        }
        if (is_null($this->get("product"))) {
            return false;
        }
        return parent::hasOptions();
    }

    function isUseStandardTemplate()
    {
        return $this->get("gcid") == "" && parent::isUseStandardTemplate();
    }

    function getURL()
    {
        if ($this->get("gcid")) {
        return CART_SELF . "?target=add_gift_certificate&gcid=" . $this->get("gcid");
        }
        return parent::getURL();
    }

}
// WARNING :
// Please ensure that you have no whitespaces / empty lines below this message.
// Adding a whitespace or an empty line below this line will cause a PHP error.
?>
