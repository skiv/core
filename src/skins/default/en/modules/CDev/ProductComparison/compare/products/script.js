/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Product comparison
 *
 * @author    Creative Development LLC <info@cdev.ru>
 * @copyright Copyright (c) 2011-2012 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.litecommerce.com/
 */

core.bind(
  'load',
  function() {
    decorate(
      'ProductsListView',
      'postprocess',
      function(isSuccess, initial)
      {
        arguments.callee.previousMethod.apply(this, arguments);

        if (isSuccess) {
          jQuery('div.product').mouseover(
            function() {
              jQuery(this).addClass('compare');
            }
          ).mouseout(
            function() {
              jQuery(this).removeClass('compare');
            }
          );
    
          jQuery('div.compare-popup').mouseleave(
            function() {
              jQuery(this).removeClass('visible');
            }
          );
    
          product_comparison();
        }
      }
    );
  }
);
