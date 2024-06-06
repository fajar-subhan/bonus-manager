<?php 
/**
 * Form Helpers
 *
 * @subpackage	Helper
 * @category	Form Helper
 * @author		Fajar Subhan
 * 
 */


/** 
 * Create a form helper for the select html tag
 * 
 * @param string $name      attribute name
 * @param string $style     the style of an html tag
 * @param array  $data      the value from the database
 * @param string $selected  attribute selected
 * @param string $event     event javascript on change
 * @param string $attr      add attribute html
 * @return string $cmb      return an html select tag
 * 
*/
if(!function_exists('Combo'))
{
    function Combo($name = '',$style = '',$data = [],$selected = '',$event = '',$attr = '')
    {
        $name = htmlentities(strip_tags(trim($name)));

        /* If no event or attribute from html */
        if(!empty($event) || !empty($attr))
        {
            $cmb = "<select name='$name' id='$name' class='$style' onchange='$event' $attr>";
        }
        else 
        {
            $cmb = "<select name='$name' id='$name' class='$style'>";
        }

        if(is_array($data))
        {
            foreach($data as $key => $value)
            {
                /* If selected is not null and $key is equal to the value of $selected */
                if(!empty($selected) && $selected == $key)
                {
                    $cmb .= "<option value='$key' selected>$value</option>";
                }
                else
                {
                    $cmb .= "<option value='$key'>$value</option>";
                }
            }
        }

        $cmb .= "</select>";

        return $cmb;
    }
}


/** 
 * Create a form helper for the hidden input html tag
 * 
 * @param  string  $name      attribute name
 * @param  string  $data      the value from the database
 * @return string  $hidden    return an html input type hidden 
 * 
*/
if(!function_exists('Hidden'))
{
    function Hidden(string $name = '',string $data = '')
    {
        $hidden = "<input type='hidden' name='$name' id='$name' value='$data'>";

        return $hidden;
    }
}
