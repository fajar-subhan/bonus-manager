<?php

/**
 * All Helpers
 *
 * @subpackage	Helpers
 * @category	All Helpers
 * @author		Fajar Subhan
 * @since       v1.0
 * 
 */

/**
 * Clean the incoming data from the input form and retrieve 
 * the data via the post method
 *
 * @return object $post
 */
if (!function_exists('Post')) {
    function Post()
    {
        $post = null;

        $method = $_SERVER['REQUEST_METHOD'];

        if ($method == 'POST') {
            foreach ($_POST as $key => $value) {
                $post[$key] = htmlentities(strip_tags(trim(filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS))));
            }
        }

        return (object)$post;
    }
}


/**
 * Clean the incoming data from the input form and retrieve 
 * the data via the get method
 *
 * @return object $get
 */
if (!function_exists('Get')) {
    function Get()
    {
        $get = null;

        $method = $_SERVER['REQUEST_METHOD'];

        if ($method == "GET") {
            foreach ($_GET as $key => $value) {
                $get[$key] = htmlentities(strip_tags(trim(filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS))));
            }
        }

        return (object)$get;
    }
}

/**
 * Check if the user is logged in or not
 * If login is true
 * If not logged in false
 *  
 *  @return boolean $login 
 */
if (!function_exists('IsLogin')) {
    function IsLogin()
    {
        $CI = &get_instance();

        if ($CI->session->userdata('login') == 1) {
            return true;
        } else {
            return false;
        }
    }
}

/** 
 * debug data 
 * 
 * @return array 
 */
if (!function_exists('ShowArray')) {
    function ShowArray($data = "")
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
}

/**
 * Take the user's ip address
 * 
 * @return string $ip_address
 */
if (!function_exists('GetIP')) {
    function GetIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }

        return $ip_address;
    }
}

/**
 * Retrieve the browser information used by the user
 * 
 * @return string $browser
 */
if (!function_exists('GetBrowser')) {
    function GetBrowser()
    {
        $USER_AGENT = [];

        foreach ($_SERVER as $key => $val) {
            // Takes only strings that start with HTTP_
            if (!strncmp("HTTP_", $key, 5)) {
                $USER_AGENT[$key] = $val;
            }
        }

        // Google Chrome 
        if (strpos($USER_AGENT['HTTP_USER_AGENT'], 'Chrome') != false) {
            $browser = "Google Chrome";
        }
        // Internet Explore 
        else if (strpos($USER_AGENT['HTTP_USER_AGENT'], 'MSIE') != false) {
            $browser = "Internet Explore";
        }
        // Mozila Firefox
        else if (strpos($USER_AGENT['HTTP_USER_AGENT'], 'Firefox') != false) {
            $browser = "Mozila Firefox";
        }
        // Safari
        else if (strpos($USER_AGENT['HTTP_USER_AGENT'], 'AppleWebKit') != false) {
            $browser = "Safari";
        }
        // Unknown Browser
        else {
            $browser = "Unknown Browser";
        }

        return $browser;
    }
}

/**
 * Create a log to view user activity,
 * and enter it into the log_user_activity table
 * 
 * @param string $module : module name 
 * @param string $name   : activity name
 * @param string $desc   : User login | User logout 
 * @param string $userid : user id 
 */
if (!function_exists("EventLoger")) {
    function EventLoger($module = "", $name = "", $desc = "", $userid = "")
    {
        $CI = &get_instance();

        $CI->db->set('user_activity_module', $module);
        $CI->db->set('user_id', $userid);
        $CI->db->set('user_activity_name', $name);
        $CI->db->set('user_activity_desc', $desc);
        $CI->db->set('user_activity_address', GetIP());
        $CI->db->set('user_activity_browser', GetBrowser());
        $CI->db->set('user_activity_os', GetOS());
        $CI->db->set('created_at', date('Y-m-d H:i:s'));
        $CI->db->insert('log_user_activity');
    }
}

/**
 * Fetch Role data based on Role id.
 * Role id is taken from session data at login
 * 
 * 1 - Dosen
 * 2 - Mahasiswa
 * 3 - Admin
 * 
 * @return array    $roie
 * @var    string   $id  taken from session data at login
 */
if (!function_exists('RoleID')) {
    function RoleID($id)
    {
        $CI = &get_instance();

        $role = [];

        $data = $CI->db->select('a.id,a.name')->get('mst_roles a')->result_array();

        if (is_array($data) and !empty($data)) {
            foreach ($data as $key => $val) {
                if ($val['id'] == $id) {
                    $role = $val;
                }
            }
        }

        return $role;
    }
}

/**
 * Retrieve the operating system information the user is using
 * 
 * @return string $os
 */
if (!function_exists('GetOS')) {
    function GetOS()
    {
        $USER_AGENT = [];

        foreach ($_SERVER as $key => $value) {
            // Takes only strings that start with HTTP_
            if (!strncmp("HTTP_", $key, 5)) {
                $USER_AGENT[$key] = $value;
            }
        }

        $os      = "Unknown Operating System";

        $os_list =
            [
                'Windows 10'                =>  'windows nt 10.0',
                'Windows 8'                 =>  'windows nt 6.2',
                'Windows 7'                 =>  'windows nt 6.1',
                'Windows XP'                =>  'windows nt 5.1',
                'Windows NT 4.0'            =>  'windows nt 4.0',
                'Windows Vista'             =>  'windows nt 6.0',
                'Windows 2000'              =>  'windows nt 5.0',
                'Windows 2000 sp1'          =>  'windows nt 5.01',
                'Windows Server 2003'       =>  'windows nt 5.2',
                'Windows 98'                =>  'windows 98',
                'Windows (version unknown)' =>  'windows',
                'Open BSD'                  =>  'openbsd',
                'Linux'                     =>  'linux',
                'Sun OS'                    =>  'sunos',
                'Mac OSX Beta (Kodiak)'     =>  'mac os x beta',
                'Mac OSX Cheetah'           =>  'mac os x 10.0',
                'Mac OSX Puma'              =>  'mac os x 10.1',
                'Mac OSX Jaguar'            =>  'mac os x 10.2',
                'Mac OSX Panther'           =>  'mac os x 10.3',
                'Mac OSX Tiger'             =>  'mac os x 10.4',
                'Mac OSX Leopard'           =>  'mac os x 10.5',
                'Mac OSX Snow Leopard'      =>  'mac os x 10.6',
                'Mac OSX Lion'              =>  'mac os x 10.7',
                'Mac OSX (version unknown)' =>  'mac os x',
                'Mac OS (classic)'          =>  '(mac_powerpc)|(macintosh)',
                'QNX'                       =>  'qnx',
                'BeOS'                      =>  'beos',
                'OS/2'                      =>  'os/2',
                'SearchBot'                 =>  '(nuhk)|(googlebot)|(yammybot)|(openbot)|(slurp)|(msnbot)|(ask jeeves/teoma)|(ia_archiver)'
            ];


        if (is_array($os_list)) {
            $USER_AGENT = strtolower($USER_AGENT['HTTP_USER_AGENT']);
            if (!empty($USER_AGENT)) {
                foreach ($os_list as $os_info => $match) {
                    // Check the pattern of the array variables os_list and HTTP_USER_AGENT
                    if (preg_match("/$match/i", $USER_AGENT)) {
                        $os = $os_info;
                        break;
                    }
                }
            }
        }

        return $os;
    }
}

/**
 * Retrieve session data
 * 
 * @return array $session
 */
if (!function_exists('GetSession')) {
    function GetSession()
    {
        $CI = &get_instance();
        $session = [];

        if (!empty($CI->session->userdata())) {
            $session = $CI->session->userdata();
        }

        return $session;
    }
}

/**
 * View sql query
 * 
 * @return string $view_query
 */
if (!function_exists('DebugQuery')) {
    function DebugQuery()
    {
        $CI = &get_instance();
        echo $CI->db->last_query();
    }
}

/**
 * Retrieving information and processing data so that it can be used for encryption purpose
 * 
 * @return array $data
 */
if (!function_exists("Security")) {
    function Security()
    {
        $data = [];

        /* Read file security.ini and get config encription */
        $security =  parse_ini_file("Security.ini");

        /* Key to unlock encryption */
        $key      = hash("sha256", $security['encription_key']);

        /* Cipher_algo AES-256-CBC */
        $algo     = $security['encription_algo'];
        /* 
         * A non-null initialization vector. 
         * For the length of the character depending on the method used, 
         * 
         */
        $ivlength = openssl_cipher_iv_length($security['encription_algo']);
        $iv       = substr(hash("sha256", $security['encription_iv']), 0, $ivlength);

        $data =
            [
                'key'   => $key,
                'algo'  => $algo,
                'iv'    => $iv
            ];

        if (is_array($data)) {
            return $data;
        }
    }
}

/**
 * Create a function to encrypt a data using openssl_encrypt
 * 
 * @param   string $data
 * @return  string $encrypt
 * @link    https://www.php.net/manual/en/function.openssl-encrypt.php
 */
if (!function_exists('Encrypt')) {
    function Encrypt($data)
    {
        /* Retrieve key,algo,and iv information */
        $sec      = Security();

        /* Time to encrypt with openssl_encrypt */
        $encrypt  = base64_encode(openssl_encrypt($data, $sec['algo'], $sec['key'], 0, $sec['iv']));

        return $encrypt;
    }
}


/**
 * Create a function to decrypt a data using openssl_decrypt
 * 
 * @param   string $data
 * @return  string $decrypt
 * @link    https://www.php.net/manual/en/function.openssl-decrypt
 */
if (!function_exists('Decrypt')) {
    function Decrypt($data)
    {
        /* Retrieve key,algo,and iv information */
        $sec      = Security();

        /* Time to decrypt with openssl_decrypt */
        $decrypt  = openssl_decrypt(base64_decode($data), $sec['algo'], $sec['key'], 0, $sec['iv']);
        return $decrypt;
    }
}


/**
 * Collecting javascript files and reinstalling
 * 
 * @param array  $file
 */
if (!function_exists('Javascript')) {
    function Javascript($file = [])
    {
        /**
         * Variable to hold compile string javascript file
         * 
         * @var string $compile
         */
        $compile            = '';



        /**
         * Javascript files
         * 
         * @var array $javascript_file
         */
        $javascript_file    = [];

        /**
         * Default js file set 
         * 
         * @var array $default_file
         */
        $default_file       = GetFileJS();

        if (!empty($file) && is_array($file)) {
            $javascript_file = array_merge($default_file, $file);
        } else {
            $javascript_file = $default_file;
        }


        foreach ($javascript_file as $key => $value) {
            if($key === 'react')
            {
                foreach($value as $rows)
                {
                    $compile .= "<script type='text/babel' src=\"$rows\"></script>";
                }
            }

            if($key !== 'react')
            {
                $compile .= "<script src=\"$value\"></script>" . PHP_EOL;
            }
        }


       

        return $compile;
    }
}

/**
 * Collect the javascript file to be reassembled 
 * and return it with type array
 * 
 */
if (!function_exists('GetFileJS')) {
    function GetFileJS()
    {
        $file_js = [];

        $file_js =
            [
                /* Jquery */
                ADMINLTE    . 'plugins/jquery/jquery.min.js',
                /* Bootstrap 4 */
                ADMINLTE    . 'plugins/bootstrap/js/bootstrap.bundle.min.js',
                /* AdminLTE App */
                ADMINLTE    . 'dist/js/adminlte.min.js',
                /* Global JS */
                ASSETS      . 'js/global/global.js',
                /* Sweetalert2 */
                ASSETS      . 'plugins/sweetalert2.all.min.js',
                /* DataTables & Plugins */
                ADMINLTE    . 'plugins/datatables/jquery.dataTables.js',
                ADMINLTE    . 'plugins/datatables-bs4/js/dataTables.bootstrap4.min.js',
                
                ASSETS      . 'js/global/global.js',
                
            ];


        return $file_js;
    }
}
