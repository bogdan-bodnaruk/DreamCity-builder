<?php
class Paginator extends DRM {
    static private $tpl;
    private $table;
    private $where;
    private $andWhere;
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

    public function andWhere($where) {
        $this->andWhere = $where;
        return $this;
    }
    
    public function order($by = '', $sort = '') {
        $this->order = $by;
        $this->sort = $sort;
        return $this;
    }

    function val($name) {
        for($i=0; $i<count($this->registry()->values); $i++) {
            if(preg_match('/^'.$name.'\=[0-9]{1,5}/', $this->registry()->values[$i])) {
                list($text, $value) = explode('=', $this->registry()->values[$i]);
                return $value;
            };
        }
    }

    public function load() {
        if($this->val('onpage')!='') {
            setcookie('onpage',$this->val('onpage'),time()+14400);
            Go::back();
        } elseif(!isset($_COOKIE['onpage'])) {
			setcookie('onpage',$this->registry()->config['on_page'],time()+14400);
            Go::back();
		};
        $this->onpage = (int)$_COOKIE['onpage'];

        $array = $this->db()
                      ->table($this->table)
                      ->select()
                      ->where($this->where)
                      ->andWhere($this->andWhere)
                      ->order($this->order, $this->sort)
                      ->limit($this->val('page') * $this->onpage, $this->onpage)
                      ->query();
        while($data = mysql_fetch_array($array)) {
            if(isset($data['protect']) && preg_match('/[0-9]+/', $data['protect'])) {
                foreach($this->registry()->user_status as $key=>$val) {
                    if((int)$data['protect']==$this->registry()->user_status[$key]) {
                        $data['protect'] = $key;  
                    };
                }
            };
            parent::$values['paginator'] = array_merge($data, array('page'=>$this->val('page')));
            $this->data .= $this->template()->load(self::$tpl)->data();
        }
        parent::$values['paginator_buttons'] = $this->count();
        return !empty($this->data) ? $this->data : '';
    }
    
    public function count() {
        $html = '';
        $page = $this->val('page');
        $this->link = $this->registry()->controller.implode('/', $this->registry()->values);
        $this->link = strtr($this->link, array('/page='.$this->val('page') => ''));
        $count = $this->db()->table($this->table)->select()->where($this->where)->num();

        if(intval($count/$this->onpage)>0) {
            if($page>=5) {
                $html = '<a '.$this->registry()->config['paginator_link'].' href="'.$this->link.'">&nbsp;1&nbsp;</a> <a href='
                        .$this->link.'/page='.($page-5).' '.$this->registry()->config['paginator_link'].'>&nbsp;...&nbsp;</a> ';
            };

            $start = ($page <= 4 ? 0 : $page - 4);
            $end = ($page <= 4 ? 8 : $page + 4);
            $end = ($end * $this->onpage)  > $count ? $count/$this->onpage : $end;
            for ($i=$start; $i<$end; $i++) {
                if(($i==$page) && $end!==1) {
                    $html .= '<span '.$this->registry()->config['active_link'].'>&nbsp;'.($i+1).'&nbsp;</span>&nbsp;';
                } elseif($end!==1) {
                    $html .= '<a '.$this->registry()->config['paginator_link'].' href='
                                .$this->link.'/page='.($i).'>&nbsp;'.($i+1).'&nbsp;</a>&nbsp;';
                };
            }

            if(intval($count/$this->onpage)>=8 && (intval($count/$this->onpage))-5>=$page) {
                $html .= '<a '.$this->registry()->config['paginator_link'].' href="'.$this->link.'/page='.($page+5)
                         .'">&nbsp;...&nbsp;</a> <a href="'.$this->link.'/page='.((intval($count/$this->onpage))-1)
                         .'" '.$this->registry()->config['paginator_link'].'>&nbsp;'.(intval($count/$this->onpage)).'&nbsp;</a>';
            };
            return '<div '.$this->registry()->config['paginator_class'].'>'.$html.'</div>';
        };
    }
}