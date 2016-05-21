<?php
class ExtendedInfo extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->values["2"] = "";
  }
  function key()
  {
    return $this->_get_value("1");
  }
  function set_key($value)
  {
    return $this->_set_value("1", $value);
  }
  function value()
  {
    return $this->_get_value("2");
  }
  function set_value($value)
  {
    return $this->_set_value("2", $value);
  }
}
class Info extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->values["3"] = "";
    $this->fields["4"] = "PBInt";
    $this->values["4"] = "";
    $this->fields["5"] = "PBInt";
    $this->values["5"] = "";
    $this->fields["6"] = "PBInt";
    $this->values["6"] = "";
    $this->fields["7"] = "PBString";
    $this->values["7"] = "";
    $this->fields["8"] = "PBString";
    $this->values["8"] = array();
    $this->fields["9"] = "PBString";
    $this->values["9"] = array();
    $this->fields["10"] = "PBString";
    $this->values["10"] = "";
    $this->fields["11"] = "PBString";
    $this->values["11"] = "";
    $this->fields["12"] = "PBInt";
    $this->values["12"] = "";
    $this->fields["13"] = "ExtendedInfo";
    $this->values["13"] = array();
    $this->fields["14"] = "PBString";
    $this->values["14"] = "";
    $this->fields["15"] = "PBInt";
    $this->values["15"] = "";
  }
  function channel_id()
  {
    return $this->_get_value("1");
  }
  function set_channel_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function soft_name()
  {
    return $this->_get_value("2");
  }
  function set_soft_name($value)
  {
    return $this->_set_value("2", $value);
  }
  function unique_code()
  {
    return $this->_get_value("3");
  }
  function set_unique_code($value)
  {
    return $this->_set_value("3", $value);
  }
  function os_major_ver()
  {
    return $this->_get_value("4");
  }
  function set_os_major_ver($value)
  {
    return $this->_set_value("4", $value);
  }
  function os_minor_ver()
  {
    return $this->_get_value("5");
  }
  function set_os_minor_ver($value)
  {
    return $this->_set_value("5", $value);
  }
  function os_bit()
  {
    return $this->_get_value("6");
  }
  function set_os_bit($value)
  {
    return $this->_set_value("6", $value);
  }
  function mac()
  {
    return $this->_get_value("7");
  }
  function set_mac($value)
  {
    return $this->_set_value("7", $value);
  }
  function cpu($offset)
  {
    $v = $this->_get_arr_value("8", $offset);
    return $v->get_value();
  }
  function append_cpu($value)
  {
    $v = $this->_add_arr_value("8");
    $v->set_value($value);
  }
  function set_cpu($index, $value)
  {
    $v = new $this->fields["8"]();
    $v->set_value($value);
    $this->_set_arr_value("8", $index, $v);
  }
  function remove_last_cpu()
  {
    $this->_remove_last_arr_value("8");
  }
  function cpu_size()
  {
    return $this->_get_arr_size("8");
  }
  function hard_disk($offset)
  {
    $v = $this->_get_arr_value("9", $offset);
    return $v->get_value();
  }
  function append_hard_disk($value)
  {
    $v = $this->_add_arr_value("9");
    $v->set_value($value);
  }
  function set_hard_disk($index, $value)
  {
    $v = new $this->fields["9"]();
    $v->set_value($value);
    $this->_set_arr_value("9", $index, $v);
  }
  function remove_last_hard_disk()
  {
    $this->_remove_last_arr_value("9");
  }
  function hard_disk_size()
  {
    return $this->_get_arr_size("9");
  }
  function mainboard()
  {
    return $this->_get_value("10");
  }
  function set_mainboard($value)
  {
    return $this->_set_value("10", $value);
  }
  function version()
  {
    return $this->_get_value("11");
  }
  function set_version($value)
  {
    return $this->_set_value("11", $value);
  }
  function virtual_machine()
  {
    return $this->_get_value("12");
  }
  function set_virtual_machine($value)
  {
    return $this->_set_value("12", $value);
  }
  function other_text($offset)
  {
    return $this->_get_arr_value("13", $offset);
  }
  function add_other_text()
  {
    return $this->_add_arr_value("13");
  }
  function set_other_text($index, $value)
  {
    $this->_set_arr_value("13", $index, $value);
  }
  function remove_last_other_text()
  {
    $this->_remove_last_arr_value("13");
  }
  function other_text_size()
  {
    return $this->_get_arr_size("13");
  }
  function secret_key()
  {
    return $this->_get_value("14");
  }
  function set_secret_key($value)
  {
    return $this->_set_value("14", $value);
  }
  function time()
  {
    return $this->_get_value("15");
  }
  function set_time($value)
  {
    return $this->_set_value("15", $value);
  }
}
?>