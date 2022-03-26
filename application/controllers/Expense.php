<?php if (!defined('BASEPATH'))exit('No direct script access allowed');


class Expense extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');
    }





    function expense_category($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'insert'){
            $this->crud_model->insertExpenseCategory();
            $this->session->set_flashdata('flash_message', translate('expense_category_saved'));  
            redirect(base_url(). 'expense/expense_category', 'refresh');
        }

        if($param1 == 'update'){
            $this->crud_model->updateExpenseCategory($param2);
            $this->session->set_flashdata('flash_message', translate('expense_category_updated'));  
            redirect(base_url(). 'expense/expense_category', 'refresh');
        }

        if($param1 == 'delete'){
            $this->crud_model->deleteExpenseCategory($param2);
            $this->session->set_flashdata('flash_message', translate('expense_category_deleted'));  
            redirect(base_url(). 'expense/expense_category', 'refresh');
        }

        $page_data['page_name'] = 'expense_category';
        $page_data['page_title'] = translate('expense_category');
        $this->load->view('back/index', $page_data);  
    }



    function expense($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'insert'){
            $this->crud_model->insertExpense();
            $this->session->set_flashdata('flash_message', translate('expense_saved'));  
            redirect(base_url(). 'expense/expense', 'refresh');
        }

        if($param1 == 'update'){
            $this->crud_model->updateExpense($param2);
            $this->session->set_flashdata('flash_message', translate('expense_updated'));  
            redirect(base_url(). 'expense/expense', 'refresh');
        }

        if($param1 == 'delete'){
            $this->crud_model->deleteExpense($param2);
            $this->session->set_flashdata('flash_message', translate('expense_deleted'));  
            redirect(base_url(). 'expense/expense', 'refresh');
        }

        $page_data['page_name'] = 'expense';
        $page_data['page_title'] = translate('manage_expense');
        $this->load->view('back/index', $page_data);  
    }




}