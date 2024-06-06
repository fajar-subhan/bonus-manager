<?php 
/**
 * Dropdown Form Helpers
 *
 * @subpackage	Helpers
 * @category	Dropdown Helpers
 * @author		Fajar Subhan
 * 
 */
class M_Dropdown extends CI_Model
{
    /**
     * Instance new object property
     * 
     * @var     object $instance  
     * @return  object $instance
     */
    private static $instance = null;

    public static function Instance()
    {
        if(is_null(self::$instance))
        {
            return self::$instance = new self();
        }

        return self::$instance;
    }
        
    /**
     * Retrieve privilege data
     * 
     * @var     array $array_result
     * @return  array $array_result
     */
    public function _Privilege()
    {
        $array_result = [];

        $this->db->select('
        a.id,
        a.name',false);
        $this->db->from('mst_roles a');
        $this->db->order_by('order','asc');
        $get = $this->db->get();

        if($get->num_rows() > 0)
        {
            foreach($get->result_array() as $rows)
            {
                $array_result[$rows['id']] = $rows['name'];
            }
        }

        return $array_result;
    }

    /**
    * Retrieve gender data 
    * 
    * @var     array $array_result
    * @return  array $array_result
    */
    public function _Gender()
    {
        $array_result = [];

        $this->db->select('
        a.gender_code as code,
        a.gender_name as name',false);
        $this->db->from('ref_gender a');
        $this->db->where('a.gender_active',1);
        $this->db->order_by('a.gender_order','ASC');
        $get = $this->db->get();

        if($get->num_rows() > 0)
        {
            foreach($get->result_array() as $rows)
            {
                $array_result[$rows['code']] = $rows['name'];
            }
        }

        return $array_result;
    }

    /**
     * Retrieve religion data
     * 
     * @var     array $array_result
     * @return  array $array_result
     */
    public function _Religion()
    {
        $array_result = [];

        $this->db->select('
        a.religion_id as id,
        a.religion_name as name
        ',false);
        $this->db->from('ref_religion a');
        $this->db->where('a.religion_active',1);
        $this->db->order_by('a.religion_order','ASC');
        $get = $this->db->get();

        if($get->num_rows() > 0)
        {
            foreach($get->result_array() as $rows)
            {
                $array_result[$rows['id']] = $rows['name'];
            }
        }

        return $array_result;
    }

    /**
     * Retrieve faculty data
     * 
     * @var     array $array_result
     * @return  array $array_result
     */
    public function _Faculty()
    {
        $array_result = [];

        $this->db->select('
        a.faculty_code as code,
        a.faculty_name as name
        ',false);
        $this->db->from('ref_faculty a');
        $this->db->where('faculty_active',1);
        $this->db->order_by('faculty_order','ASC');
        $get = $this->db->get();

        if($get->num_rows() > 0)
        {
            foreach($get->result_array() as $rows)
            {
                $array_result[$rows['code']] = $rows['name'];
            }
        }
        
        return $array_result;
    }

    /**
     * Create dropdowns for study programs bases 
     * on selected faculties
     * 
     * @var     array $result 
     * @return  array $result
     */
    public function _Study()
    {
        $array_result = [];

        $this->db->select('
        a.study_code as code,
        a.study_name as name
        ',false);
        $this->db->from('ref_study_program a');
        $this->db->where('a.study_active',1);
        $this->db->where('a.study_faculty_code',Post()->code);
        $this->db->order_by('a.study_order','ASC');
        $get = $this->db->get();

        if($get->num_rows() > 0)
        {
            foreach($get->result_array() as $rows)
            {
                $array_result[$rows['code']] = $rows['name'];
            }
        }

        return $array_result;
    }

    /**
     * Retrieve class program data
     * 
     * @var     array $array_result 
     * @return  array $array_result
     */
    public function _ClassProgram()
    {
        $array_result = [];

        $this->db->select('
        a.program_code as code,
        a.program_name as name
        ',false);
        $this->db->from('ref_class_program a');
        $this->db->where('a.program_active',1);
        $this->db->order_by('a.program_order','ASC');
        $get = $this->db->get();

        if($get->num_rows() > 0)
        {
            foreach($get->result_array() as $rows)
            {
                $array_result[$rows['code']] = $rows['name'];
            }
        }

        return $array_result;
    }

    /**
     * Retrieve lecturer data
     * 
     * @var     array $array_result
     * @return  array $array_result 
     */
    public function _Lecturer()
    {
        $array_result = [];

        $this->db->select('
        a.lecturer_nidn as nidn,
        a.lecturer_name as name
        ',false);
        $this->db->from('mst_lecturer a');
        $this->db->where('a.lecturer_active',1);
        $this->db->order_by('a.lecturer_order','ASC');
        $get = $this->db->get();

        if($get->num_rows() > 0)
        {
            foreach($get->result_array() as $rows)
            {
                $array_result[$rows['nidn']] = $rows['name'];
            }
        }

        return $array_result;
    }

    /**
     * Retrieve study program data
     * 
     * @var     array $array_result
     * @return  array $array_result 
     */
    public function _StudyProgram()
    {
        $array_result = [];

        $this->db->select('
        a.study_code AS `code`,
        a.study_name AS `name`
        ',false);
        $this->db->from('ref_study_program a');
        $this->db->where('a.study_active',1);
        $this->db->order_by('a.study_order','ASC');

        $get = $this->db->get();

        if($get->num_rows() > 0)
        {
            foreach($get->result_array() as $rows)
            {
                $array_result[$rows['code']] = $rows['name'];
            }
        }

        return $array_result;
    }

    /**
     * List of subject
     * 
     * @var     array $array_result
     * @return  array $array_result 
     */
    function _ListSubject()
    {
        $array_result = [];

        $this->db->select('
        a.subject_code AS `code`,
        a.subject_name AS `name`
        ',false);
        $this->db->from('mst_subject a');
        $this->db->where('a.subject_active',1);
        $this->db->order_by('a.subject_order','ASC');

        $get = $this->db->get();

        if($get->num_rows() > 0)
        {
            foreach($get->result_array() as $rows)
            {
                $array_result[$rows['code']] = $rows['name'];
            }
        }

        return $array_result;
    }

}
