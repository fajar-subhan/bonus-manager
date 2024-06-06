<?php
class Bonus extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('M_Bonus');
    }

    public function index()
    {
        if (!IsLogin()) {
            redirect(base_url('auth'));
        }

        $data =
            [
                'title_module'  => 'Data Bonus Karyawan',
                'javascript'    => Javascript(
                    [
                        ASSETS . 'plugins/babel.min.js',
                        'https://unpkg.com/react@18/umd/react.production.min.js',
                        'https://unpkg.com/react-dom@18/umd/react-dom.production.min.js',
                        'react' => [
                            ASSETS . 'js/bonus/bonus.js'
                        ]
                    ],

                ),
            ];

        $this->template->view('template/template', 'bonus/view_bonus_index', $data);
    }

    public function data()
    {
        $data = $this->M_Bonus->_getData();

        header('Content-type: application/json');
        echo json_encode($data);
    }

    public function store()
    {

        $result = ['status' => false, 'message' => null];


        $store = $this->M_Bonus->_addStore($_POST);

        if ($store['status']) {
            $result = ['status' => true, 'message' => 'success'];
        }

        echo json_encode($result);
    }

    public function show()
    {
        $data =  $this->M_Bonus->_show(Decrypt(Get()->id));
        
        echo json_encode($data);
    }

    public function update()
    {
        $result = ['status' => false, 'message' => null];

        $update = $this->M_Bonus->_update();

        if ($update['status']) {
            $result = ['status' => true, 'message' => 'success'];
        }

        echo json_encode($result);
    }

    public function destroy()
    {
        $result = ['status' => false, 'message' => null];

        $destory = $this->M_Bonus->_destroy();
        if ($destory['status']) {
            $result = ['status' => true, 'message' => 'success'];
        }

        echo json_encode($result);
    }
}
