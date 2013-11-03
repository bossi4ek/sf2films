/**
 * Created with JetBrains PhpStorm.
 * User: root
 * Date: 21.10.13
 * Time: 22:04
 * To change this template use File | Settings | File Templates.
 */

setRandomMessage = function(obj)
{
  if ($(obj).is(":checked")) {
      $("#post_message").attr("disabled","disabled");
  }
  else {
      $("#post_message").removeAttr("disabled");
  }
};
