<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(isset($_SESSION['userRole'])){
    if($_SESSION['userRole'] == '1'){
        redirect('admin');
    }else{
        redirect('user');
    }
}else{
    header('Location: '.site_url('member'));
}

?>