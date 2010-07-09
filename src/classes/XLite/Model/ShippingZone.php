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
 * @category   LiteCommerce
 * @package    XLite
 * @subpackage Model
 * @author     Creative Development LLC <info@cdev.ru> 
 * @copyright  Copyright (c) 2010 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version    SVN: $Id$
 * @link       http://www.litecommerce.com/
 * @see        ____file_see____
 * @since      3.0.0
 */

/**
 * ____description____
 * 
 * @package XLite
 * @see     ____class_see____
 * @since   3.0.0
 */
class XLite_Model_ShippingZone extends XLite_Model_AModel
{
    public $fields = array(
        "shipping_zone" => 0
        );
    public $isRead = true;

    public function __construct($zone = null)
    {
        parent::__construct();
        if (isset($zone)) {
            $this->set('shipping_zone', $zone);
        }
    }
    
    function findAll($where = null, $orderby = null, $groupby = null, $limit = null)
    {
        $states = $this->db->getTableByAlias('states');
        $countries = $this->db->getTableByAlias('countries');
        $array1 = $this->db->getAll("SELECT DISTINCT shipping_zone from $states order by shipping_zone");
        $array2 = $this->db->getAll("SELECT DISTINCT shipping_zone from $countries order by shipping_zone");
        $array = array_merge($array1, $array2); // state zones first
        return $this->_zonesArray($array);
    }

    function findCountryZones()
    {
        $countries = $this->db->getTableByAlias('countries');
        $array = $this->db->getAll("SELECT DISTINCT shipping_zone from $countries order by shipping_zone");
        return $this->_zonesArray($array);
    }

    function findStateZones()
    {
        $states = $this->db->getTableByAlias('states');
        $array = $this->db->getAll("SELECT DISTINCT shipping_zone from $states order by shipping_zone");
        return $this->_zonesArray($array);
    }

    function _zonesArray($array)
    {
        $zones = array();
        foreach ($array as $zone) {
            $zone_object = new XLite_Model_ShippingZone();
            $zone_object->_updateProperties($zone);
            $zones[$zone['shipping_zone']] = $zone_object;
        }
        if (!isset($zones[0])) {
            $z = new XLite_Model_ShippingZone();
            $z->set('shipping_zone', 0);
            $zones[0] = $z;
        }
        return $zones;
    }

    function find($where, $order = null)
    {
        $this->doDie("find() not applicable on ShippingZone");
    }

    function update()
    {
        $this->doDie("update() not applicable on ShippingZone");
    }

    function delete()
    {
        $this->doDie('Not implemented');
    }

    function create()
    {
        $states = $this->db->getTableByAlias('states');
        $countries = $this->db->getTableByAlias('countries');
        $max1 = $this->db->getOne("SELECT MAX(shipping_zone) from $states");
        $max2 = $this->db->getOne("SELECT MAX(shipping_zone) from $countries");
        $this->set('shipping_zone', max($max1, $max2)+1);
    }

    function getCountries()
    {
        if (!isset($this->countries)) {
            $this->countries = XLite_Core_Database::getRepo('XLite_Model_Country')
                ->findByShippingZone($this->get('shipping_zone'));
        }

        return $this->countries;
    }

    function getStates()
    {
        if (!isset($this->states)) {
            $this->states = XLite_Core_Database::getRepo('XLite_Model_State')
                ->findByShippingZone($this->get('shipping_zone'));
        }

        return $this->states;
    }

    function hasCountries()
    {
        return 0 < count($this->getCountries());
    }

    function hasStates()
    {
        return 0 < count($this->getStates());
    }

    function setCountries($countries)
    {
        list($keys, $parameters) = XLite_Core_Database::prepareArray($countries);
        $list = XLite_Core_Database::getQB()
            ->select('c')
            ->from('XLite_Model_Country', 'c')
            ->where('c.shipping_zone IN (' . implode(', ', $keys) . ')')
            ->setParameters($parameters)
            ->getQuery()
            ->getResult();

        foreach ($lists as $c)
        {
            $c->shipping_zone = $this->get('shipping_zone');
            XLite_Core_Database::getEM()->persist($c);
        }
        XLite_Core_Database::getEM()->flush();

        if (isset($this->countries)) {
        	unset($this->countries);
        }
    }

    function setStates($states)
    {
        $list = XLite_Core_Database::getQB()
            ->select('s')
            ->from('XLite_Model_State', 's')
            ->where('s.state_id IN (:ids)')
            ->setParameter('ids', $states)
            ->getQuery()
            ->getResult();
                

        foreach ($list as $s)
        {
            $s->shipping_zone = $this->get('shipping_zone');
            XLite_Core_Database::getEM()->persist('s');
        }

        XLite_Core_Database::getEM()->flush();

        if (isset($this->states)) {
        	unset($this->states);
        }
    }

    function get($name)
    {
        if ($name == "name") {
            if ($this->get('shipping_zone') == 0) {
                return "Default zone";
            } else {
                return "Zone ".$this->get('shipping_zone');
            }
        }
        return parent::get($name);
    }

}
