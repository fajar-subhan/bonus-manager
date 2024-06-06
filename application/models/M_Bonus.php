<?php 
class M_Bonus extends CI_Model 
{
    /**
     * Primary table mst_bonus
     * 
     * @var string $primary_table
     */
    private $primary_table = "mst_bonus a";
    
    public function _getData()
    {
        $result = [];

        $this->db->select('*',false);
        $this->db->from($this->primary_table);
        $rst = $this->db->get();
        
        if($rst->num_rows() > 0)
        {
            $i = 0;
            foreach($rst->result_array() as $rows)
            {
                $result[$i]['id']       = Encrypt($rows['id']);
                $result[$i]['tanggal']  = $rows['created_at'];
                $result[$i]['total']    = $rows['total_bonus'];
                $i++;
            }
        }

        return $result;
    }

    public function _addStore($data)
    {
        $result = ['status' => false];
        $total_bonus = $data['totalNumberBonus'];

        $this->db->set('total_bonus',$total_bonus);
        $this->db->set('created_at',date('Y-m-d H:i:s'));
        $this->db->set('created_uid',GetSession()['id']);
        $insert = $this->db->insert('mst_bonus');
        if($insert)
        {
            $id     = $this->db->insert_id();
            foreach($data['buruh'] as $rows)
            {
                $this->db->set('bonus_id',$id);
                $this->db->set('name',$rows['name']);
                $this->db->set('percentase',$rows['percentase']);
                $this->db->set('amount',$rows['amountBonus']);
                $this->db->set('created_at',date('Y-m-d H:i:s'));
                $this->db->set('created_uid',GetSession()['id']);
                $rst = $this->db->insert('mst_bonus_distribution');

                if($rst AND $insert)
                {
                    $result = ['status' => true];
                }
            }
        }

        return $result;
    }

    public function _show($id)
    {
        $sql = "SELECT 
        a.id,
        b.id as id_distribution,
        a.total_bonus AS total_bonus,
        b.name,
        b.percentase,
        b.amount
        FROM mst_bonus a 
        INNER JOIN mst_bonus_distribution b ON a.id = b.bonus_id
        WHERE a.id = $id
        ORDER BY b.bonus_id ASC
        ";

        $rst = $this->db->query($sql);

        $result = ['status' => false,'data' => []];
        if($rst->num_rows() > 0)
        {
            $data = $rst->result_array();

            $total_bonus            = number_format($data[0]['total_bonus'],0,',','');
            $id_bonus               = Encrypt($data[0]['id']);
            $buruh_list = [];
            foreach($data as $rows)
            {
                $buruh_list[] = [
                    'id'            => Encrypt($rows['id_distribution']),
                    'name'          => $rows['name'],
                    'percentase'    => (int)$rows['percentase'],
                    'amount'        => $rows['amount'],
                ];
            }

            $percentase_array = array_column($buruh_list,'percentase');
            $total_persentase = array_sum($percentase_array);


            $result = [
                'status'            => true,
                'total_bonus'       => $total_bonus,
                'buruh'             => $buruh_list,
                'total_persentase'  => $total_persentase,
                'id_bonus'          => $id_bonus
            ];
        }

        return $result;
    }

    public function _update()
    {
        $result = ['status' => false];

        // update mst_bonus
        $this->db->set('total_bonus',$_POST['totalNumberBonus']);
        $this->db->set('updated_at',date('Y-m-d H:i:s'));
        $this->db->set('updated_uid',GetSession()['id']);
        $this->db->where('id',Decrypt($_POST['idBonus']));

        if($this->db->update('mst_bonus'))
        {
            foreach($_POST['buruh'] as $rows)
            {
                $this->db->set('percentase',$rows['percentase']);
                $this->db->set('amount',$rows['amount']);
                $this->db->set('updated_at',date('Y-m-d H:i:s'));
                $this->db->set('updated_uid',GetSession()['id']);
                $this->db->where('id',Decrypt($rows['id']));
                if($this->db->update('mst_bonus_distribution'))
                {
                    $result = ['status' => true];
                }
            }
        }

        return $result;
    }

    public function _destroy()
    {
        $result = ['status' => false];

        $this->db->where('id',Decrypt($_POST['id']));
        if($this->db->delete('mst_bonus'))
        {
            $this->db->where('bonus_id',Decrypt($_POST['id']));
            if($this->db->delete('mst_bonus_distribution'))
            {
                $result = ['status' => true];
            }
        }

        return $result;
    }
}