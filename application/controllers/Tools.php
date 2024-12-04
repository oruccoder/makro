<?php

/**
 * İtalic Soft Yazılım  ERP - CRM - HRM 
 * Copyright (c) İtalic Soft Yazılım. Tüm Hakları Saklıdır.
 * ***********************************************************************
 *
 *  Email: info@italicsoft.com
 *  Website: https://www.italicsoft.com
 *  Tel: 0850 317 41 44
 *  ************************************************************************
 */




defined('BASEPATH') OR exit('No direct script access allowed');



class Tools Extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        $this->load->library("Aauth");

        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }

        if (!$this->aauth->premission(11)) {



            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');



        }

         $this->load->model('tools_model', 'tools');



    }



    //todo section



    public function todo()

    {

        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = 'Görev Listesi';

        $data['totalt'] = $this->tools->task_count_all();



        $this->load->view('fixed/header', $head);

        $this->load->view('todo/index', $data);

        $this->load->view('fixed/footer');



    }



    public function addtask()

    {

        $this->load->model('employee_model', 'employee');

        $head['usernm'] = $this->aauth->get_user()->username;

        $data['emp'] = $this->employee->list_employee();

        $head['title'] = 'Görev Ekle';



        $this->load->view('fixed/header', $head);

        $this->load->view('todo/addtask', $data);

        $this->load->view('fixed/footer');



    }



    public function edittask()

    {

        if ($this->input->post()) {

            $id = $this->input->post('id');

            $name = $this->input->post('name',true);

            $status = $this->input->post('status');

            $priority = $this->input->post('priority');

            $stdate = $this->input->post('staskdate',true);

            $tdate = $this->input->post('taskdate',true);

            $employee = $this->input->post('employee');

            $content = $this->input->post('content');

            $stdate = datefordatabase($stdate);

            $tdate = datefordatabase($tdate);



            if ($this->tools->edittask($id, $name, $status, $priority, $stdate, $tdate, $employee, $content)) {

                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED')."  <a href='todo' class='btn btn-indigo btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));

            } else {

                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

            }

        } else {



            $this->load->model('employee_model', 'employee');



            $head['usernm'] = $this->aauth->get_user()->username;

            $data['emp'] = $this->employee->list_employee();

            $head['title'] = 'Edit Task';



            $id = $this->input->get('id');

            $data['task'] = $this->tools->viewtask($id);



            $this->load->view('fixed/header', $head);

            $this->load->view('todo/edittask', $data);

            $this->load->view('fixed/footer');

        }



    }



    public function save_addtask()

    {

        $name = $this->input->post('name',true);

        $status = $this->input->post('status');

        $priority = $this->input->post('priority');

        $stdate = $this->input->post('staskdate');

        $tdate = $this->input->post('taskdate');

        $employee = $this->input->post('employee');

        $content = $this->input->post('content');

        $assign = $this->aauth->get_user()->id;

        $stdate = datefordatabase($stdate);

        $tdate = datefordatabase($tdate);



        if ($this->tools->addtask($name, $status, $priority, $stdate, $tdate, $employee, $assign, $content)) {

            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('New Task Added')."  <a href='addtask' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a>   <a href='todo' class='btn btn-blue btn-lg'><span class='icon-list-ul' aria-hidden='true'></span>  </a>"));

        } else {

            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

        }



    }



    public function set_task()

    {

        $id = $this->input->post('tid');
        $status=1;

        $stat = $this->input->post('stat');
        if($stat=='Done')
        {
            $status=3;
        }

        $this->tools->settask($id, $status);

        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED'), 'pstatus' => 'Success'));





    }



    public function view_task()

    {

        $id = $this->input->post('tid');



        $task = $this->tools->viewtask($id);


        $derece='';

        if($task['priority']=='Low')
        {
            $derece='Düşük';
        }
        else if($task['priority']=='Medium')
        {
            $derece='Orta';
        }
        else if($task['priority']=='High')
        {
            $derece='Yüksek';
        }
        else if($task['priority']=='Urgent')
        {
            $derece='Acil';
        }



        echo json_encode(array('name' => $task['name'], 'description' => $task['description'], 'employee' => $task['emp'], 'assign' => $task['assign'], 'priority' => $derece));

    }



    public function task_stats()

    {



        $this->tools->task_stats();





    }



    public function delete_i()

    {

        $id = $this->input->post('deleteid');



        if ($this->tools->deletetask($id)) {

            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

        }

    }





    public function todo_load_list()

    {

        $cday = $this->input->get('cday');

        $list = $this->tools->task_datatables($cday);

        $data = array();

        $no = $this->input->post('start');



        foreach ($list as $task) {

            $no++;

            $name = '<a class="check text-default" data-id="' . $task->id . '" data-stat="Due"> <i class="icon-check"></i> </a><a href="#" data-id="' . $task->id . '" class="view_task">' . $task->name . '</a>';

            if ($task->status == 'Done') {

                $name = '<a class="check text-success" data-id="' . $task->id . '" data-stat="Done"> <i class="icon-check"></i> </a><a href="#" data-id="' . $task->id . '" class="view_task">' . $task->name . '</a>';

            }

            $row = array();

            $row[] = $no;

            $row[] = '<a href="#" class="btn btn-primary btn-sm rounded set-task" data-id="' . $task->id . '" data-stat="0"> Tamamla </a>' . $name;

            $row[] = dateformat($task->duedate);

            $row[] = dateformat($task->start);

            $row[] = '<span class="task_' . $task->status . '">' . $this->lang->line('Task '.$task->status) . '</span>';



            $row[] = '<a class="btn-info btn-sm" href="edittask?id=' . $task->id . '" data-object-id="' . $task->id . '"> <i class="icon-pencil"></i> </a>&nbsp;<a class="btn-brown btn-sm delete-object" href="#" data-object-id="' . $task->id . '"> <i class="icon-trash-o"></i> </a>';




            $data[] = $row;

        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->tools->task_count_all($cday),

            "recordsFiltered" => $this->tools->task_count_filtered($cday),

            "data" => $data,

        );

        echo json_encode($output);

    }





    //set goals



    public function setgoals()

    {

        if ($this->input->post('income')) {



            $income = (float)$this->input->post('income');

            $expense = (float)$this->input->post('expense');

            $sales = (float)$this->input->post('sales');

            $netincome = (float)$this->input->post('netincome');





            if ($this->tools->setgoals($income, $expense, $sales, $netincome)) {

                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED')));

            } else {

                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

            }

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;

            $head['title'] = 'Set Goals';

            $data['goals'] = $this->tools->goals(1);



            $this->load->view('fixed/header', $head);

            $this->load->view('goals/index', $data);

            $this->load->view('fixed/footer');

        }



    }



    //notes



    public function notes()

    {

        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = 'Notes';

        $this->load->view('fixed/header', $head);

        $this->load->view('notes/index');

        $this->load->view('fixed/footer');

    }





    public function notes_load_list()

    {

        $list = $this->tools->notes_datatables();

        $data = array();

        $no = $this->input->post('start');

        foreach ($list as $note) {

            $status='';
            if(!is_numeric($note->status))
            {
                $status=$note->status;
            }
           else if($note->status==0)
            {
                $status='Bekliyor';
            }
            else if($note->status==1)
            {
                $status='Beklet';
            }
            else if($note->status==2)
            {
                $status='Randevu Ayarla';
            }
           else if($note->status==3)
            {
                $status='Onaylandı';
            }
            else if($note->status==4)
            {
                $status="Burçak'a Yönlendir";
            }

            else if($note->status==5)
            {
                $status="Milad'a Yönlendir";
            }
            else if($note->status==6)
            {
                $status="Lamiya'ya Yönlendir";
            }
            else if($note->status==7)
            {
                $status="Fevzi'ye Yönlendir";
            }
            else if($note->status==8)
            {
                $status="Nijat'a Yönlendir";
            }
            else if($note->status==9)
            {
                $status="Mahir'e Yönlendir";
            }
            else if($note->status==10)
            {
                $status="Hacı Ali'ye Yönlendir";
            }
            else if($note->status==11)
            {
                $status="İlqar Mikayilov Yönlendir";
            }
            else if($note->status==13)
            {
                $status="İlqar Nesibov Yönlendir";
            }

            if($note->gorusme_durumu==0)
            {
                $btn='<a style="color:white" onclick="gorusme_durumu('.$note->id .')" class="btn btn-info btn-sm"><span class="fa fa-check"></span>Görüşmeye Gerçekleştir</a>';
            }
            else
            {
                $btn='Görüşme Gerçekleşti';
            }

            $row = array();

            $no++;

            $row[] = $no;

            $row[] = $note->title;

            $row[] = $note->last_edit;
            $row[] = personel_detailsa($note->cid)['name'];
            $row[] =$status ;
            $row[] =$btn ;



           // $row[] = '<a href="editnote?id=' . $note->id . '" class="btn btn-info btn-sm"><span class="icon-eye"></span> ' . $this->lang->line('View') . '</a> <a class="btn btn-danger btn-sm delete-object" href="#" data-object-id="' . $note->id . '"> <i class="icon-trash "></i> </a>';
            $row[] = '<a href="editnote?id=' . $note->id . '" class="btn btn-info btn-sm"><span class="icon-eye"></span> ' . $this->lang->line('View') . '</a> ';

            $data[] = $row;

        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->tools->notes_count_all(),

            "recordsFiltered" => $this->tools->notes_count_filtered(),

            "data" => $data,

        );

        echo json_encode($output);

    }


    public function gorusme_onayla()
    {
       $id = $this->input->get('id');
        $this->db->set('gorusme_durumu', "1");

        $this->db->where('id', $id);

        if($this->db->update('geopos_notes'))
        {

            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED'), 'pstatus' => 'Başarıyla İşleminiz Tamamlandı'));
        }
    }


    public function addnote()

    {

        if ($this->input->post('title')) {



            $title = $this->input->post('title',true);

            $content = $this->input->post('content');
            $pers_id = $this->input->post('pers_id');



            if ($this->tools->addnote($title, $content,$pers_id)) {

                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED')."  <a href='addnote' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a>"));

            } else {

                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

            }

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;

            $head['title'] = 'Add Note';

            $this->load->view('fixed/header', $head);

            $this->load->view('notes/addnote');

            $this->load->view('fixed/footer');

        }



    }



    public function editnote()

    {

        if ($this->input->post('title')) {

            $id = $this->input->post('id');

            $title = $this->input->post('title',true);

            $content = $this->input->post('content');
            
            $pers_id = $this->input->post('pers_id');



            if ($this->tools->editnote($id, $title, $content,$pers_id)) {

                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED')."  <a href='editnote?id=$id' class='btn btn-indigo btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));

            } else {

                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

            }

        } else {

            $id = $this->input->get('id');

            $data['note'] = $this->tools->note_v($id);

            $head['usernm'] = $this->aauth->get_user()->username;

            $head['title'] = 'Edit';

            $this->load->view('fixed/header', $head);

            $this->load->view('notes/editnote', $data);

            $this->load->view('fixed/footer');

        }



    }





    public function delete_note()

    {

        $id = $this->input->post('deleteid');



        if ($this->tools->deletenote($id)) {

            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

        }

    }





    //documents





    public function documents()

    {



        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = 'Documents';

        $this->load->view('fixed/header', $head);

        $this->load->view('notes/documents');

        $this->load->view('fixed/footer');





    }



    public function document_load_list()

    {

        $list = $this->tools->document_datatables();

        $data = array();

        $no = $this->input->post('start');

        foreach ($list as $document) {

            $row = array();

            $no++;

            $row[] = $no;

            $row[] = $document->title;

            $row[] = dateformat($document->cdate);



            $row[] = '<a href="' . base_url('userfiles/documents/' . $document->filename) . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> ' . $this->lang->line('View') . '</a> <a class="btn btn-danger btn-xs delete-object" href="#" data-object-id="' . $document->id . '"> <i class="fa fa-trash" aria-hidden="true"></i> </a>';





            $data[] = $row;

        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->tools->document_count_all(),

            "recordsFiltered" => $this->tools->document_count_filtered(),

            "data" => $data,

        );

        echo json_encode($output);

    }





    public function adddocument()

    {



        $this->load->helper(array('form'));

        $data['response'] = 3;

        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = 'Add Document';



        $this->load->view('fixed/header', $head);



        if ($this->input->post('title')) {

            $title = $this->input->post('title',true);

            $config['upload_path'] = './userfiles/documents';

            $config['allowed_types'] = 'docx|docs|txt|pdf|xls';

            $config['encrypt_name'] = TRUE;

            $config['max_size'] = 3000;

            $this->load->library('upload', $config);



            if (!$this->upload->do_upload('userfile')) {

                $data['response'] = 0;

                $data['responsetext'] = 'File Upload Error';



            } else {

                $data['response'] = 1;

                $data['responsetext'] = 'Document Uploaded Successfully. <a href="documents"

                                       class="btn btn-grey btn-md"><i

                                                class="icon-folder"></i>

                                    </a>';

                $filename = $this->upload->data()['file_name'];

                $this->tools->adddocument($title, $filename);

            }



            $this->load->view('notes/adddocument', $data);

        } else {





            $this->load->view('notes/adddocument', $data);





        }

        $this->load->view('fixed/footer');





    }





    public function delete_document()

    {

        $id = $this->input->post('deleteid');



        if ($this->tools->deletedocument($id)) {

            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

        }

    }





    public function pendingtasks()

    {

        $tasks = $this->tools->pending_tasks();



        $tlist = '';

        $tc = 0;

        foreach ($tasks as $row) {





            $tlist .= '<a href="javascript:void(0)" class="list-group-item">

                      <div class="media">

                        <div class="media-left valign-middle"><i class="icon-bullhorn2 icon-bg-circle bg-cyan"></i></div>

                        <div class="media-body">

                          <h6 class="media-heading">' . $row['name'] . '</h6>

                          <p class="notification-text font-small-2 text-muted">Due date is ' . dateformat($row['duedate']) . '.</p><small>

                            Start <time  class="media-meta text-muted">' . dateformat($row['start']) . '</time></small>

                        </div>

                      </div></a>';

            $tc++;

        }



        echo json_encode(array('tasks' => $tlist, 'tcount' => $tc));





    }





}