<?php
namespace Common\Helper;

/**
 * 表单核心类
 */
class Form
{

    /**
     * Generates an opening HTML form tag.
     *
     * // Form will submit back to the current page using POST
     * echo Form::open();
     *
     * // Form will submit to 'search' using GET
     * echo Form::open('search', array('method' => 'get'));
     *
     * // When "file" inputs are present, you must include the "enctype"
     * echo Form::open(null, array('enctype' => 'multipart/form-data'));
     *
     * @param   string  form action, defaults to the current request URI
     * @param   array   html attributes
     * @return  string
     * @uses	HttpIO::instance
     * @uses	URL::site
     * @uses	HTML::attributes
     */
    public static function open($action = null, array $attributes = null)
    {
        if ( $action === null )
        {
            // Use the current URI
            $action = HttpIO::current()->uri;
        }

        if ( strpos($action, '://') === false )
        {
            // Make the URI absolute
            $action = Core::url($action);
        }

        // Add the form action to the attributes
        $attributes['action'] = $action;

        // Only accept the default character set
        $attributes['accept-charset'] = Core::$charset;

        if ( ! isset($attributes['method']) )
        {
            // Use POST method
            $attributes['method'] = 'post';
        }

        return '<form' . HTML::attributes($attributes) . '>';
    }

    /**
     * Creates the closing form tag.
     *
     * echo Form::close();
     *
     * @return  string
     */
    public static function close()
    {
        return '</form>';
    }

    /**
     * Creates a form input. If no type is specified, a "text" type input will
     * be returned.
     *
     * echo Form::input('username', $username);
     *
     * @param   string  input name
     * @param   string  input value
     * @param   array   html attributes
     * @return  string
     * @uses	HTML::attributes
     */
    public static function input($name, $value = null, array $attributes = null)
    {
        // Set the input name
        $attributes['name'] = $name;

        // Set the input value
        $attributes['value'] = $value;

        //add the input class
//        $attributes['class'] .= ' input-small';

        if ( ! isset($attributes['type']) )
        {
            // Default type is text
            $attributes['type'] = 'text';
        }

        if ($attributes['type'] == 'text' && !isset($attributes['min']) && (!$attributes['value'] || preg_match('#^[0-9.]+$#',$attributes['value'])) && (int)$attributes['value']>=0 )
        {
            $attributes['min'] = '0';
        }

        return '<input' . HTML::attributes($attributes) . ' />';
    }

    /**
     * Creates a hidden form input.
     *
     * echo Form::hidden('csrf', $token);
     *
     * @param   string  input name
     * @param   string  input value
     * @param   array   html attributes
     * @return  string
     * @uses	Form::input
     */
    public static function hidden($name, $value = null, array $attributes = null)
    {
        $attributes['type'] = 'hidden';

        return Form::input($name, $value, $attributes);
    }

    /**
     * Creates a password form input.
     *
     * echo Form::password('password');
     *
     * @param   string  input name
     * @param   string  input value
     * @param   array   html attributes
     * @return  string
     * @uses	Form::input
     */
    public static function password($name, $value = null, array $attributes = null)
    {
        $attributes['type'] = 'password';

        return Form::input($name, $value, $attributes);
    }

    /**
     * Creates a file upload form input. No input value can be specified.
     *
     * echo Form::file('image');
     *
     * @param   string  input name
     * @param   array   html attributes
     * @return  string
     * @uses	Form::input
     */
    public static function file($name, array $attributes = null)
    {
        $attributes['type'] = 'file';

        return Form::input($name, null, $attributes);
    }

    /**
     * Creates a checkbox form input.
     *
     * echo Form::checkbox('remember_me', 1, (bool) $remember);
     *
     * @param   string   input name
     * @param   string   input value
     * @param   boolean  checked status
     * @param   array	html attributes
     * @return  string
     * @uses	Form::input
     */
    public static function checkbox($name, $value = null, $checked = false, array $attributes = null)
    {
        $attributes['type'] = 'checkbox';

        if ( $checked === TRUE )
        {
            // Make the checkbox active
            $attributes['checked'] = 'checked';
        }

        return Form::input($name, $value, $attributes);
    }

    /**
     * Creates a radio form input.
     *
     * echo Form::radio('like_cats', 1, $cats);
     * echo Form::radio('like_cats', 0, ! $cats);
     *
     * @param   string   input name
     * @param   string   input value
     * @param   boolean  checked status
     * @param   array	html attributes
     * @return  string
     * @uses	Form::input
     */
    public static function radio($name, $value = null, $checked = false, array $attributes = null)
    {
        $attributes['type'] = 'radio';

        if ( $checked === TRUE )
        {
            // Make the radio active
            $attributes['checked'] = 'checked';
        }

        return Form::input($name, $value, $attributes);
    }

    /**
     * Creates a textarea form input.
     *
     * echo Form::textarea('about', $about);
     *
     * @param   string   textarea name
     * @param   string   textarea body
     * @param   array	html attributes
     * @param   boolean  encode existing HTML characters
     * @return  string
     * @uses	HTML::attributes
     * @uses	HTML::chars
     */
    public static function textarea($name, $body = '', array $attributes = null, $double_encode = false)
    {
        // Set the input name
        $attributes['name'] = $name;

        // Add default rows and cols attributes (required)
        $attributes += array('rows' => 10, 'cols' => 50);

        return '<textarea' . HTML::attributes($attributes) . '>' . HTML::chars($body, $double_encode) . '</textarea>';
    }

    /**
     * Creates a select form input.
     *
     * echo Form::select('country', $countries, $country);
     *
     * @param   string   input name
     * @param   array	available options
     * @param   mixed	selected option string, or an array of selected options
     * @param   array	html attributes
     * @return  string
     * @uses	HTML::attributes
     */
    public static function select($name, array $options = null, $selected = null, array $attributes = null)
    {
        // Set the input name
        $attributes['name'] = $name;

        // add the select class
        $attributes['class'] = 'input-small ' . (isset($attributes['class']) ? $attributes['class'] : '');

        if ( is_array($selected) )
        {
            // This is a multi-select, god save us!
            $attributes['multiple'] = 'multiple';
        }

        if ( ! is_array($selected) )
        {
            if ( $selected === null )
            {
                // Use an empty array
                $selected = array();
            }
            else
            {
                // Convert the selected options to an array
                $selected = array((string)$selected);
            }
        }

        if ( empty($options) )
        {
            // There are no options
            $options = '';
        }
        else
        {
            foreach ( $options as $value => $name )
            {
                if ( is_array($name) )
                {
                    // Create a new optgroup
                    $group = array('label' => $value);

                    // Create a new list of options
                    $_options = array();

                    foreach ( $name as $_value => $_name )
                    {
                        // Force value to be string
                        $_value = (string)$_value;

                        // Create a new attribute set for this option
                        $option = array('value' => $_value);

                        if ( in_array($_value, $selected) )
                        {
                            // This option is selected
                            $option['selected'] = 'selected';
                        }

                        // Change the option to the HTML string
                        $_options[] = '<option' . HTML::attributes($option) . '>' . HTML::chars($_name, false) . '</option>';
                    }

                    // Compile the options into a string
                    $_options = "\n" . implode("\n", $_options) . "\n";

                    $options[$value] = '<optgroup' . HTML::attributes($group) . '>' . $_options . '</optgroup>';
                }
                else
                {
                    // Force value to be string
                    $value = (string)$value;

                    // Create a new attribute set for this option
                    $option = array('value' => $value);

                    if ( in_array($value, $selected) )
                    {
                        // This option is selected
                        $option['selected'] = 'selected';
                    }

                    // Change the option to the HTML string
                    $options[$value] = '<option' . HTML::attributes($option) . '>' . HTML::chars($name, false) . '</option>';
                }
            }

            // Compile the options into a single string
            $options = "\n" . implode("\n", $options) . "\n";
        }

        return '<select' . HTML::attributes($attributes) . '>' . $options . '</select>';
    }

    /**
     * Creates a submit form input.
     *
     * echo Form::submit(null, 'Login');
     *
     * @param   string   input name
     * @param   string  input value
     * @param   array   html attributes
     * @return  string
     * @uses	Form::input
     */
    public static function submit($name , $value, array $attributes = null)
    {
        $attributes['type'] = 'submit';

        if (!isset($attributes['class'])) {
            $attributes['class'] = '';
        }
        $attributes['class'] .= ' btn btn-primary';

        return Form::input($name, $value, $attributes   );
    }

    /**
     * Creates a image form input.
     *
     * echo Form::image(null, null, array('src' => 'media/img/login.png'));
     *
     * @param   string   input name
     * @param   string   input value
     * @param   array	html attributes
     * @param   boolean  add index file to URL?
     * @return  string
     * @uses	Form::input
     */
    public static function image($name, $value, array $attributes = null, $index = false)
    {
        if ( ! empty($attributes['src']) )
        {
            if ( strpos($attributes['src'], '://') === false )
            {
                $attributes['src'] = Core::url($attributes['src'] , $index);
            }
        }

        $attributes['type'] = 'image';

        return Form::input($name, $value, $attributes);
    }

    /**
     * Creates a button form input. Note that the body of a button is NOT escaped,
     * to allow images and other HTML to be used.
     *
     * echo Form::button('save', 'Save Profile', array('type' => 'submit'));
     *
     * @param   string  input name
     * @param   string  input value
     * @param   array   html attributes
     * @return  string
     * @uses	HTML::attributes
     */
    public static function button($name, $body, array $attributes = null)
    {
        // Set the input name
        $attributes['name'] = $name;

        $attributes['type']     = 'button';
        if (!isset($attributes['class'])) {
            $attributes['class'] = '';
        }
        $attributes['class']   .= ' btn btn-primary';
        return Form::input($name, $body, $attributes);

//        return '<button' . HTML::attributes($attributes) . '>' . $body . '</button>';
    }

    /**
     * Creates a form label. Label text is not automatically translated.
     *
     * echo Form::label('username', 'Username');
     *
     * @param   string  target input
     * @param   string  label text
     * @param   array   html attributes
     * @return  string
     * @uses	HTML::attributes
     */
    public static function label($input, $text = null, array $attributes = null)
    {
        if ( $text === null )
        {
            // Use the input name as the text
            $text = ucwords(preg_replace('/\W+/', ' ', $input));
        }

        // Set the label target
        $attributes['for'] = $input;

        return '<label' . HTML::attributes($attributes) . '>' . $text . '</label>';
    }


    /**
     * 时间输入框
     *
     * @param   string  input name
     * @param   string  input value
     * @param   array   html attributes
     * @return  string
     * @uses	Form::input
     * @uses	HTML::attributes
     */
    public static function input_time($name, $value = '', array $attributes = null , $showinput = true)
    {
        $attributes['time'] = true;
        return Form::input_date($name, $value , $attributes , $showinput);
    }

    /**
     * 日期输入框
     *
     * @param   string  input name
     * @param   string  input value
     * @param   array   html attributes
     * @return  string
     * @uses	Form::input
     * @uses	HTML::attributes
     */
    public static function input_date($name, $value = '', array $attributes = null , $showinput = true)
    {
//        $attributes['type'] = $attributes['time']?'datetime':'date';
//        $time = isset($attributes['time']) ? $attributes['time'] : false;
//        unset($attributes['time']);
//
//        return Form::input($name, is_numeric($value)&&$value>0? date("Y-m-d" . ($time ? ' H:i:s' : ''), $value > 0 ? $value : TIME ):$value, $attributes );
        $sHtml = <<<EOF
            <script>
                $(function() {
                    var es = $('input[name="{$name}"]');
                    es.datepicker({showButtonPanel: true});
                    es.datepicker($.datepicker.regional[ "zh-CN" ]);
                    es.datepicker("option", "dateFormat", "yy-mm-dd");
                });
            </script>
EOF;
        if (!isset($attributes['class'])) {
            $attributes['class'] = '';
        }
        $attributes['class'] .= ' input-small';
        $sHtml .= Form::input($name, $value, $attributes);
        return $sHtml;
    }

    /**
     * 输出一个带下拉的input框
     *
     *     // 简单的输出例子
     *     Form::input_select('test', 1, array('a,'b','c'));
     *
     *     // 带JS设置的处理方式
     *     <script>
     *     var set_input = function(obj)
     *     {
     *         obj.url = '/test.php';
     *         obj.method = 'POST';
     *     }
     *     </script>
     *     <?php
     *     Form::input_select('test', 1, array('a,'b','c') , array('size'=>4) , 'set_input');
     *     ?>
     *
     * @param string $name
     * @param string $value
     * @param array $options
     * @param array $attributes
     * @param string $calljs 回调JS方法
     */
    public static function input_select($name, $value = null, $options = array(), array $attributes = null , $calljs = null )
    {
        if (!is_array($attributes))
        {
            $attributes = array();
        }
        if (!is_array($options))
        {
            $options = array();
        }

        $attributes['_is_inputselect'] = 'true';
        $attributes['onclick'] = 'if (!this._o){this._o = new LianMeng.suggest(this);this._o.options = '.json_encode($options).';this._o.correction_left = 1;this._o.correction_top = 2;this._o.correction_width = 2;this._o.correction_height = 3;'.($calljs?'try{'.$calljs.'(this._o);}catch(e){}':'').';this.onfocus();}'.(isset($attributes['onclick'])?$attributes['onclick']:'');

        $attributes2 = array
        (
            '_is_inputselect_show' => 'true',
            'onclick' => 'this.style.display=\'none\';var obj=this.nextSibling;if(typeof obj == "object" && obj.getAttribute(\'_is_inputselect\')==\'true\'){obj.style.display=\'\';obj.focus();obj.onclick();}',
            'onfocus' => 'this.click()',
        );
        if (isset($attributes['size'])) $attributes2['size'] = $attributes['size'];
        if (isset($attributes['style'])) $attributes2['style'] = $attributes['style'];
        if (isset($attributes['class'])) $attributes2['class'] = $attributes['class'];
        $attributes['style'] = 'display:none;' . (isset($attributes['style']) ? $attributes['style'] : '');
        return '<span class="input_select_div">'.Form::input(null , $options[$value] , $attributes2 ).Form::input($name , $value , $attributes ).'</span>';
	}

    public static function checkbox_popup($sName, $aOption, $aSelected = array()) {
        if (substr($sName,-2)!='[]') {
            $newname = $sName.'[]';
        } else {
            $newname = $sName;
        }
        if ($_GET[$sName] === 'all') {
            $aSelected = 'all';
        } else if (isset($_GET[$sName])) {
            $aSelected = $_GET[$sName];
        }
        $aSelected = (array)$aSelected;

        $bSelectAll = in_array('all', $aSelected) ? 1 : 0;
        $sSelected  = json_encode($aSelected);
        $sOption   = json_encode($aOption);

        $unid = uniqid('checkbox_zone_');
        $str = <<<EOF
        <style>
            span#{$unid}select {
                position: absolute;
                z-index : 0;
                width : 100px;
                height : 24px;
                cursor : pointer;
            }

            span#{$unid} {
                box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.1);
                margin: 24px 0 0 -1px;
                position: absolute;
                z-index: 1;
                width: 740px;
                white-space: nowrap;
                max-height: 300px;
                overflow: auto;
                background: #fff;
            }
        </style>
EOF;
        $str .= <<<EOF
            <span onmouseover="checkbox_zone_over=true;" onmouseout="checkbox_zone_over=false;">
                <span id="{$unid}select" onclick="checkbox_show(this);"></span>
                <span style="display: none;" data-name="{$sName}" data-newname="{$newname}" name="checkbox_html" id="{$unid}"></span>
                <select style="width:100px;cursor:pointer;" onmousedown="checkbox_show(document.getElementById('{$unid}select'));event.preventDefault();">
                    <option>请选择</option>
                </select>
EOF;
        $str .= <<<EOF
<script>
checkbox_zone_over = false;
function checkbox_show(obj) {
    if (obj.nextSibling.style.display == 'none') {
        obj.nextSibling.style.display = '';
        setTimeout(function(){
            document.body._onclick = document.body.onclick;
            document.body.onclick = function(){
                if (checkbox_zone_over) return;
                obj.nextSibling.style.display = 'none';
                document.body.onclick = document.body._onclick;
                delete document.body._onclick;
                return false;
            };
        },20);
    } else {
        obj.nextSibling.style.display = 'none';
        document.body.onclick = document.body._onclick;
        delete document.body._onclick;
    }
}
function checkbox_server_check(table){
    if (table.tagName!='TABLE')return;
    var objs = table.getElementsByTagName('INPUT');
    var check_num = 0;
    var check_all = false;

    for(var i=0;i<objs.length;i++) {
        if (objs[i].checked){if (objs[i].value=='all'){check_all=true;}else if(objs[i].value){check_num++;}objs[i].setAttribute('checked','checked')}else{objs[i].removeAttribute('checked')};
        if (objs[i].disabled){objs[i].setAttribute('disabled','disabled')}else{objs[i].removeAttribute('disabled')};
    }

    table.parentNode.parentNode.getElementsByTagName(LianMeng.is_ie && LianMeng.ie<7?'h4':'option')[0].innerHTML = check_all?'全部':(check_num>0?'已选择'+check_num+'个':'请选择');
}
var form_all_servers = {$sOption};
function checkbox_ini(obj,selected_all,selected) {
    var name = obj.getAttribute('data-name')||'server_ids';
    var newname = obj.getAttribute('data-newname')||'server_ids[]';
    selected_all = selected_all || false;
    selected = selected || [];
    var str = '<table class="mainTable"><tbody><tr><th colspan=4 class="center">';
    str += '<label style="display : inline;"><input value="all" name="'+name+'"'+(selected_all?' checked="checked"':'')+' type="checkbox" onclick="var table=this.parentNode.parentNode.parentNode.parentNode.parentNode;var objs = table.getElementsByTagName(\'input\');for(var i=0;i<objs.length;i++){if (objs[i]!==this){if (this.checked){objs[i].disabled=true;objs[i]._checked=objs[i].checked;objs[i].checked=true;objs[i].setAttribute(\'disabled\',\'disabled\')}else{objs[i].disabled=false;objs[i].checked=objs[i]._checked;objs[i]._checked = null;objs[i].removeAttribute(\'disabled\')}if (objs[i].type==\'checkbox\' && objs[i].onclick){objs[i].onclick();}};}checkbox_server_check(table);this.blur();" />全选</label> &nbsp; &nbsp;';
    str += '<input value="反选" type="button"'+(selected_all?' disabled="disabled"':'')+' onclick="var table=this.parentNode.parentNode.parentNode.parentNode.parentNode;var objs = table.getElementsByTagName(\'input\');for(var i=0;i<objs.length;i++){if (objs[i].name&&objs[i].type==\'checkbox\'&&objs[i].value!=\'all\'){if (objs[i].checked){objs[i].checked=false;objs[i].removeAttribute(\'checked\');}else{objs[i].checked=true;objs[i].setAttribute(\'checked\',\'checked\');};if (objs[i].onclick){objs[i].onclick();}};};checkbox_server_check(table);" />';
    str += '</th></tr><tr>';

    var i=0,str2='';
    for (var id in form_all_servers) {
        var sname = form_all_servers[id];
        var checked = false;
            if (selected_all) {
                checked = true;
            } else {
                for(var ii=0;ii<selected.length;ii++) {
                    if (selected[ii]==id) {
                        checked = true;
                        break;
                    }
                }
            }
            if (i>0&&i%4==0) {
                str += '</tr><tr>';
            }
            i++;
            str += '<td width="25%" style="background:'+(checked?'#d8fec7':'#fff')+';" onmouseover="var ckd=this.getElementsByTagName(\'INPUT\')[0].checked;this.style.background=ckd?\'#c4f7ad\':\'#f4f4f4\';" onmouseout="var ckd=this.getElementsByTagName(\'INPUT\')[0].checked;this.style.background=ckd?\'#d8fec7\':\'#fff\';"><label style="display:block;cursor:pointer;"><input name="'+newname+'" value="'+id+'" type="checkbox"'+(selected_all?' disabled="disabled"':'')+(checked?' checked="checked"':'')+' onclick="checkbox_server_check(this.parentNode.parentNode.parentNode.parentNode.parentNode);this.parentNode.parentNode.onmouseover();this.blur();">'+sname+'</label></td>';
    }
    if (i<4) {
        str = str.replace(/colspan=4/i, "colspan=" + i);
    }

    str += '</tr></tbody></table>';

    obj.innerHTML = str;

    checkbox_server_check(obj.getElementsByTagName('TABLE')[0]);
}

checkbox_ini(LianMeng.$('{$unid}'),{$bSelectAll},{$sSelected});
</script>
EOF;

        $str .= '</span>';
        return str_replace(array('  ',"\n","\r"),'',$str);
    }

}