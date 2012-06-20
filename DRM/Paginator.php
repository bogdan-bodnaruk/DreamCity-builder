<?php
class Paginator extends DRM {
    static private $tpl;
    private $table;
    private $where;
    private $order;
    private $onpage;
    private $data;
    private $sort;
    private $link;
    static public $buttons;
    
    function __call($name, $values) {
        Logger::error('Can\'n call method ['.$name.'('.$values.')] in class Paginator');
    }
    
    function __get($name) {
        Logger::error('Can\'t get value ['.$name.'] in class Paginator');
    }
    
    function __set($name, $value) {
        Logger::error('Can\'t set value ['.$name.' = '.$value.'] in class Paginator');
    }
    
    public static function tpl($tpl) {
        if(file_exists(parent::registry()->PATH.'/views/'.$tpl)) {
            self::$tpl = $tpl;
        } else {
            Logger::error('Can\'t find file ['.$tpl.'] in class '.__CLASS__.'');  
        };
        return new self();
    }
    
    public function table($table) {
        $this->table = $table;
        return $this;
    }
    
    public function where($where) {
        $this->where = $where;
        return $this;
    }
    
    public function order($by = '', $sort = '') {
        $this->order = $by;
        $this->sort = $sort;
        return $this;
    }
    
    public function load() {
        $page = 0;
        $link = '';
        for($i = 2; $i<count($this->registry()->values)+2; $i++) {
            if(isset($this->registry()->values[$i])) {
                if(preg_match('/page\=[0-9]{1,5}/', $this->registry()->values[$i])) {
                    list($text, $page) = explode('=', $this->registry()->values[$i]);
                    $page = $page-1;
                } elseif($this->registry()->values[$i]=='&ajax=true' || $this->registry()->values[$i]=='&ajax') {
                    
                } else {
                    $link .= $this->registry()->values[$i];
                }
            };
        }
        $this->link = $this->registry()->controller.$link;
        $this->onpage = $this->registry()->config['items_onpage'];
        $array = $this->db()
                 ->table($this->table)
                 ->select()
                 ->where($this->where)
                 ->order($this->order, $this->sort)
                 ->limit($page*$this->onpage, $this->onpage)
                 ->query();
        while($data = mysql_fetch_array($array)) {
            if(isset($data['protect']) && preg_match('/[0-9]+/', $data['protect'])) {
                foreach($this->registry()->user_status as $key=>$val) {
                    if((int)$data['protect']==$this->registry()->user_status[$key]) {
                        $data['protect'] = $key;  
                    };
                }
            };
            parent::$values[''] = $data;
            $this->data .= $this->template()->load(self::$tpl)->return_data();
        }
        parent::$values['paginator_buttons'] = $this->count($page);
        return !empty($this->data) ? $this->data : '';
    }
    
    public function count($page) {
        $count = $this->db()
                      ->table($this->table)
                      ->select()
                      ->where($this->where)
                      ->num();
        if(intval($count/$this->onpage)>0) {
            $str = $page>=5
                        ? '<a '.$this->registry()->config['paginator_link'].' href="'.$this->link.'">&nbsp;1&nbsp;</a> <a href='
                            .$this->link.'/page='.($page-4).' '.$this->registry()->config['paginator_link'].'>&nbsp;...&nbsp;</a> '
                        : '';
                        
            switch($page) {
                case(0):
                    $start = $page - 0;
                    $end = $page + 8;
                break;
                case(1):
                    $start = $page - 1;
                    $end = $page + 7;
                break;
                case(2):
                    $start = $page - 2;
                    $end = $page + 6;
                break;
                case(3):
                    $start = $page - 3;
                    $end = $page + 5;
                break;
                default:
                    $start = $page - 4;
                    $end = $page + 4;
                break;
            }
            $end = $end*$this->onpage>$count ? $count/$this->onpage : $end;
            $start = $start<0 ? 0 : $start;
    
            for ($i=$start;$i<$end;$i++) {
                $str .= $i==$page
                        ? '<span '.$this->registry()->config['active_link'].'>&nbsp;'.($i+1).'&nbsp;</span>&nbsp;'
                        : '<a '.$this->registry()->config['paginator_link'].' href='.$this->link.'/page='.($i+1).'>&nbsp;'.($i+1).'&nbsp;</a>&nbsp;';
            }
            
            $str .= intval($count/$this->onpage)+1>=8 && (intval($count/$this->onpage))-5>=$page
                    ? ' <a '.$this->registry()->config['paginator_link'].' href='.$this->link.'/page='.($page+5).'>&nbsp;...&nbsp;</a> <a href='
                        .$this->link.'page='.(intval($count/$this->onpage))
                        .' '.$this->registry()->config['paginator_link'].'>&nbsp;'.(intval($count/$this->onpage)).'&nbsp;</a>'
                    : '';
            return '<div '.$this->registry()->config['paginator_class'].'>'.$str.'</div>';
        } else {
            return '';  
        };
    }
}