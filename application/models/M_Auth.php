<?php
class M_Auth extends CI_Model
{
    /**  
     * Primary table ref_user
     * 
     * @var string $primary_table
     * */
    private $primary_table = "ref_user a";

    /**
     *  Fetch user login data by username  
     * 
     * @param string $username 
     * */
    public function _getDataByUsername($username)
    {
        $result_array = [];

        $this->db->select('
        a.id,
        a.username,
        a.fullname,
        a.password as password,
        a.login as statuslogin,
        a.role_id as role', false);
        $this->db->from($this->primary_table);
        $this->db->where('a.username', $username);
        $this->db->where('active', 1);
        $get = $this->db->get();

        if ($get->num_rows() > 0) {
            $result_array =  $get->row_array();
        }

        return $result_array;
    }

    /** 
     * Update mst user table data when user login
     * 
     * @param string | int $id id user
     */
    public function _updateLogin($id)
    {
        $this->db->set('login', 1);
        $this->db->where('id', $id);
        $this->db->update($this->primary_table);
    }

    /**
     * Update user table data where user logout
     * 
     * @param string | int $id
     */
    public function _updateLogout($id)
    {
        $this->db->set('login', 0);
        $this->db->where('id', $id);
        $this->db->update($this->primary_table);
    }
}
