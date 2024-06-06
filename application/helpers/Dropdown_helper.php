<?php 
/**
 * Create object instance on M_Dropdown
 * get data on database 
 *
 * @subpackage	Helpers
 * @category	Dropdown Helpers
 * @author		Fajar Subhan
 * 
*/

/**
 * Create an M_Dropdown object
 * 
 * @var object $dropdown
 */
if(!function_exists('Dropdown'))
{
    function Dropdown()
    {
        $CI =& get_instance();
       

        // Load model M_Dropdown
        if(!class_exists('M_Dropdown'))
        {
            $CI->load->model('M_Dropdown');
        }   
        
        
        if(class_exists('M_Dropdown'))
        {
            $dropdown = M_Dropdown::Instance();
            return $dropdown;
        }

    }
}

/**
 * Take all privileges list
 * 1 - Dosen
 * 2 - Mahasiswa
 * 3 - Admin
 * 
 * @var     array $privilege
 * @return  array $privilege
 */
if(!function_exists('Privilege'))
{
    function Privilege()
    {
        $privilege = Dropdown()->_Privilege();

        return $privilege;
    }
}

/**
 * Make a list of account status
 * 
 * 1 - Aktif
 * 0 - Tidak Aktif
 * 
 * @var     array $data
 * @return  array $data
 */
if(!function_exists('AccountStatus'))
{
    function AccountStatus()
    {
        $data = 
        [
            '1' => 'Aktif',
            '0' => 'Tidak Aktif'
        ];

        return $data;
    }
}

/**
 * Retrieve gender data 
 * 
 * @var     array $gender
 * @return  array $gender 
 */
if(!function_exists('Gender'))
{
    function Gender()
    {
        $gender = Dropdown()->_Gender();

        return $gender;
    }
}

/**
 * Retrieve religion data 
 * 
 * @var     array $religion
 * @return  array $religion
 */
if(!function_exists('Religion'))
{
    function Religion()
    {
        $religion = Dropdown()->_Religion();

        return $religion;
    }
}

/**
 * Retrieve faculty data
 * 
 * @var     array $faculty
 * @return  array $faculty
 */
if(!function_exists('Faculty'))
{
    function Faculty()
    {
        $faculty = Dropdown()->_Faculty();
        $faculty = array_merge(['-' => '-- Pilih Fakultas --'],$faculty);
        return $faculty;
    }
}

/**
 * Retrieve class program data
 * 
 * @var     array $class
 * @return  array $class
 */
if(!function_exists('ClassProgram'))
{
    function ClassProgram()
    {
        $class = Dropdown()->_ClassProgram();

        return $class;
    }
}

/**
 * Retrieve lecturer data
 * 
 * @var     array $lecturer 
 * @return  array $lecturer
 */
if(!function_exists('Lecturer'))
{
    function Lecturer()
    {
        $lecturer = Dropdown()->_Lecturer();

        return $lecturer;
    }
}

/**
 * Retrieve study program data
 * 
 * @var     array $study_program
 * @return  array $study_program
 */
if(!function_exists('StudyProgram'))
{
    function StudyProgram()
    {
        $study_program = Dropdown()->_StudyProgram();

        return $study_program;
    }
}

/**
 * List of existing classes
 * 
 * @var     array $classes 
 * @return  array $classes 
 */
if(!function_exists('ListClass'))
{
    function ListClass()
    {
        $classes = 
        [
            'X1l' => 'X1l',
            'X2l' => 'X2l',
            'X3l' => 'X3l',
            'X4l' => 'X4l' 
        ];

        if(is_array($classes))
        {
            return $classes;
        }
    }
}

/**
 * List of subject
 * 
 * @var     array $subject
 * @return  array $subject 
 */
if(!function_exists('ListSubject'))
{
    function ListSubject()
    {
        $subject = Dropdown()->_ListSubject();
        return $subject;
    }
}

/**
 * List of days
 * 
 * @var     array $days
 * @return  array $days
 */
if(!function_exists('Days'))
{
    function Days()
    {
        $days = 
        [
            'Senin' => 'Senin',
            'Selasa'=> 'Selasa',
            'Rabu'  => 'Rabu',
            'Kamis' => 'Kamis',
            'Jumat' => 'Jumat',
            'Satbu' => 'Sabtu',
            'Minggu'=> 'Minggu'
        ];

        return $days;
    }
}