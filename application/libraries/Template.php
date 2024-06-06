<?php 
/**
 * Create template libraries
 * 
 * @subpackage  Libraries
 * @category    Template Libraries
 *  
 */

class Template
{
    /**
     * 
     * @var array $data
     */
    private $template_data = [];
    
    /**
     * Get object CI 
     * 
     * @var Object $ci
     */
    private $CI   = ''; 

    /**
     * 
     * @var string $name 
     * @var string $value 
     * @var array  $data
     */
    public function init($name,$value)
    {
        $this->template_data[$name] = $value;
    }

    /**
     * @var string  $template 
     * @var string  $view 
     * @var array   $data
     * @var boolean $return
     */
    public function view($template = '' , $view = '' , $data = [] , $return = false)
    {
        $this->CI =& get_instance();

        $this->init('contents',$this->CI->load->view($view,$data,TRUE));
        
        return $this->CI->load->view($template,$this->template_data,$return);
    }

}