<?php
class Controller_backup extends Controller {
    private $where = '1=1';

    public function __construct() {
        parent::__construct();
        User::login()->permissions() > 80 ? '' : Go::main();
    }

    public function index() {
        $this->template()->load('backup.tpl')->show();
    }

    public function excel() {
        include_once('excel_xml.php');
        $excel = new excel_xml();

        $header_style = array(
            'bold'       => 1,
            'italic'     => 1,
            'size'       => '9',
            'color'      => '#000000',
            'bgcolor'    => '#E6E6E6'
        );

        $excel->add_style('header', $header_style);

        $excel->add_row(array(
                            $this->i18n()->Status,
                            $this->i18n()->name,
                            $this->i18n()->surname,
                            $this->i18n()->patronymic,
                            $this->i18n()->date_of_birth,
                            $this->i18n()->country,
                            $this->i18n()->city,
                            $this->i18n()->address,
                            $this->i18n()->zip,
                            $this->i18n()->phone_home,
                            $this->i18n()->phone_mobile,
                            $this->i18n()->icq,
                            $this->i18n()->skype,
                            $this->i18n()->email,
                            $this->i18n()->gender,
                            $this->i18n()->nationality,
                            $this->i18n()->number_invitation,
                            $this->i18n()->date_invitation,
                            $this->i18n()->valid_until,
                            $this->i18n()->univer_invitation,
                            $this->i18n()->service_dispatch,
                            $this->i18n()->number_declaration,
                            $this->i18n()->number_visa,
                            $this->i18n()->date_issue_visa,
                            $this->i18n()->visa_valid_until,
                            $this->i18n()->place_issued,
                            $this->i18n()->univer_enrolled,
                            $this->i18n()->speciality,
                            $this->i18n()->lang_study,
                            $this->i18n()->number_group,
                            $this->i18n()->cost,
                            $this->i18n()->study_year,
                            $this->i18n()->address_register,
                            $this->i18n()->date_register,
                            $this->i18n()->register_until,
                            $this->i18n()->course,
                            $this->i18n()->degree,
                            $this->i18n()->level_degree,
                            $this->i18n()->univer_transferred,
                            $this->i18n()->special_enrolled,
                            $this->i18n()->course_enrolled,
                            $this->i18n()->date_enrolled
                        ), 'header');

        $this->val('id');
        if(!empty($this->val['id'])) {
            $this->where .= ' AND `id` IN('.$this->val['id'].')';
        };

        $data = $this->db()
                     ->table('profile')
                     ->select()
                     ->where($this->where)
                     ->order(Helpers::order(), Helpers::direction())
                     ->query();
        while($D = mysql_fetch_array($data)) {
            $excel->add_row(array(
                        $D['status'],
                        $D['name'],
                        $D['surname'],
                        $D['patronymic'],
                        $D['date_of_birth'],
                        $D['country'],
                        $D['city'],
                        $D['addres'],
                        $D['zip'],
                        $D['phone_home'],
                        $D['phone_mobile'],
                        $D['icq'],
                        $D['skype'],
                        $D['email'],
                        $D['gender'],
                        $D['nationality'],
                        $D['number_inv'],
                        $D['date_inv'],
                        $D['valid_until'],
                        $D['university_inv'],
                        $D['date_send'],
                        $D['service_disp'],
                        $D['number_dec'],
                        $D['number_visa'],
                        $D['date_issue_visa'],
                        $D['visa_valid_until'],
                        $D['place_issued'],
                        $D['speciality'],
                        $D['lang_study'],
                        $D['group'],
                        $D['cost'],
                        $D['study_year'],
                        $D['address_reg'],
                        $D['date_reg'],
                        $D['reg_until'],
                        $D['course'],
                        $D['degree'],
                        $D['level_degree'],
                        $D['university_transf'],
                        $D['speciality_transf'],
                        $D['course_transf'],
                        $D['date_transf']
            ));
        }

        $excel->create_worksheet('Users');
        $excel->generate();
        $excel->download('data_export_'.date("Y-m-d").'.xls');
    }

    public function files() {
        $date = date("Y-m-d");
        $dir = $this->registry()->config['files_path'].'/'.$date;
        $backup_dir = $this->registry()->config['files_path'].'/backup/';

        exec("rm -r ".$backup_dir);

        mkdir($dir);
        chmod($dir, 0777);
        mkdir($backup_dir);
        chmod($backup_dir, 0777);

        exec("mysqldump -u".$this->registry()->config['db_user']
                     ." -p".$this->registry()->config['db_password']
                     ." -h".$this->registry()->config['db_host']." "
                           .$this->registry()->config['db_table']." > ".$backup_dir."/MySQL_DataBase.sql;");

        exec("zip -r -e -P ".$this->registry()->config['zip_password']." "
                            .$backup_dir.$date.".zip ".$this->registry()->config['files_path']);

        exec("rm -r ".$dir);
        Helpers::get_file($backup_dir.$date.'.zip');
    }

    public function mysql() {
        $date = date("Y-m-d");
        $dir = $this->registry()->config['files_path'].'/'.$date;
        $backup_dir = $this->registry()->config['files_path'].'/backup/';

        exec("rm -r ".$backup_dir);

        mkdir($dir);
        chmod($dir, 0777);
        mkdir($backup_dir);
        chmod($backup_dir, 0777);

        exec("mysqldump -u".$this->registry()->config['db_user']
                     ." -p".$this->registry()->config['db_password']
                     ." -h".$this->registry()->config['db_host']." "
                           .$this->registry()->config['db_table']." > ".$backup_dir."/MySQL_DataBase.sql;");

        exec("rm -r ".$dir);
        Helpers::get_file($backup_dir.'/MySQL_DataBase.sql');
    }
}