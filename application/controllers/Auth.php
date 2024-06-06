<?php
class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Auth');
    }

    /**
     * Handle start login page 
     */
    public function index()
    {
        if (IsLogin()) {
            redirect(base_url('bonus'));
        }

        $this->load->view('auth/view_auth_index');
    }

    /**
     * Check if the username and password are in the database
     * if they are the same and valid then please login
     * 
     * @return json 
     */
    public function login()
    {
        $username   = Post()->username;
        $password   = base64_decode(Post()->password);

        /* Fetch user login data by username */
        $data_user = $this->M_Auth->_getDataByUsername($username);

        if (count($data_user) > 0) {
            /* If the password or username does not match the data in the database, then give an error message */
            if (!password_verify($password, $data_user['password']) || $data_user['username'] !== $username) {
                $error =
                    [
                        'status'    => false,
                        'message'   => "Username atau password salah",
                    ];
            }

            /* If everything is done and correct */ else {
                /* check if remember me is checked */
                $remember = Post()->remember;

                /* if true or checked then create a cookie */
                if ($remember == "true") {
                    setcookie("username", Encrypt($username), time() + 60 * 60 * 24 * 7, '/');
                    setcookie("password", Encrypt($password), time() + 60 * 60 * 24 * 7, '/');
                } else {
                    setcookie("username", "");
                    setcookie("password", "");
                }

                $error =
                    [
                        'status'    => true,
                        'message'   => 'Berhasil',
                    ];

                $data_session =
                    [
                        'username'  => $data_user['username'],
                        'fullname'  => $data_user['fullname'],
                        'role'      => $data_user['role'],
                        'login'     => 1,
                        'id'        => $data_user['id']
                    ];

                /* Update some column in database when user login */
                $this->M_Auth->_updateLogin($data_user['id']);

                /* Create log login */
                EventLoger("Auth", "Login", "User Login", $data_user['id']);

                $this->session->set_userdata($data_session);
            }
        }
        /**
         * If the password or username don't match, then give an error message.
         * And also the account not found
         */
        else {
            $error =
                [
                    'status'    => false,
                    'message'   => "Username atau password salah",
                ];
        }

        header('Content-Type: application/json');
        echo json_encode($error);
    }

    /**
     * To exit the session
     * 
     */
    public function logout()
    {   
        EventLoger("Auth","Logout","User Logout",GetSession()['id']);
        $this->M_Auth->_updateLogout(GetSession()['id']);
        $this->session->sess_destroy();
        redirect(base_url('auth'));
    }
}
