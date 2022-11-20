<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Api extends REST_Controller {
    
      /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->helper('generic');
       $this->load->model('User', 'user');
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_get($id = 0)
    {
        $this->response(array('API'=>"Check documentation!"));
    }
      
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_post()
    {
        $this->response(array('API'=>"post call!"));
    } 
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_put($id)
    {
        // $input = $this->put();
        // $this->db->update('items', $input, array('id'=>$id));
     
        // $this->response(['Item updated successfully.'], REST_Controller::HTTP_OK);
        $this->response(array('API'=>"put call!"));
    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_delete($id)
    {
        // $this->db->delete('items', array('id'=>$id));
       
        // $this->response(['Item deleted successfully.'], REST_Controller::HTTP_OK);
        $this->response(array('API'=>"delete call!"));
    }

    public function logout_get(){
        // $this->session->unset_userdata('logged_in');
        session_destroy();
    } 

    public function sign_in_post(){
        $response['status']='failure';
        $response['message']='';
        $response['error_code']=1;

        $email = $this->post('email');
        $pass = $this->post('password');
        if (($email == "") && ($pass == "")) {
            $response['message'] = "enter username and password";
        } else {
            $data = array(
                'email' => trim($email),
                'password' => md5(trim($pass))
            );
            
            $result = $this->user->checklogin($data);

            if ($result != false) {
                $response['message']= 'You have successfully logged in';
                $response['status']='success';
                $response['error_code']=0;
                $response['data']=$result;
                
            } else {
                $response['message'] = 'Invalid Username or Password'; 
            }
        }

        $this->response($response);
        
    }

    public function user_post(){
        $response['status']='failure';
        $response['message']='';
        $response['error_code']=1;

        $data['username'] = $this->post('username');
        $data['fp1'] = $this->post('fp1');
        $data['fp2'] = $this->post('fp2');
        $data['fp3'] = $this->post('fp3');
        $data['fp4'] = $this->post('fp4');
        $data['fp5'] = $this->post('fp5');
        $data['created_at'] = date('Y-m-d H:i:s');

        if(!empty($data)){
            $this->user->createUser($data);     
            $response['message']='You have been Successfully registered';
            $response['status']='success';
            $response['error_code']=0;          
        }else{
                $response['message']='All The Fields Are Required';
            }
            
        $this->response($response);
    } 

    public function attendance_post(){
        $response['status']='failure';
        $response['message']='';
        $response['error_code']=1;

        $data['user_id'] = $this->post('user_id');
        $data['cp_id'] = $this->post('cp_id');
        $data['glat'] = $this->post('lat');
        $data['glng'] = $this->post('lng');
        $data['created_at'] = date('Y-m-d H:i:s');

        if(!empty($data)){
            $this->user->createAttendance($data);     
            $response['message']='Attendance Successfull';
            $response['status']='success';
            $response['error_code']=0;
        }else{
                $response['message']='All The Fields Are Required';
            }
            
        $this->response($response);
    } 

    public function checkpost_post(){
        $response['status']='failure';
        $response['message']='';
        $response['error_code']=1;

        $data['cp_name'] = $this->post('name');
        $data['created_at'] = date('Y-m-d H:i:s');

        if(!empty($data)){
            $this->user->add_checkpost($data);     
            $response['message']='Your checkpost created';
            $response['status']='success';
            $response['error_code']=0;
        }else{
                $response['message']='All The Fields Are Required';
            }
            
        $this->response($response);
    }   
        
}