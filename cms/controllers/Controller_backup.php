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