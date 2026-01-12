<?php 

class Helper {
    
    public static function toAscii($str, $replace=[], $delimiter='-') {
        if( !empty($replace) ) {
            $str = str_replace((array)$replace, ' ', $str);
        }
        
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        
        return $clean;
    }
    
    public static function DB_insert($table, $data) {
        $key = [];
        $val = [];
        $tmp = [];
        
        foreach ($data as $k=>$v) {
            $key[] = $k;
            $val[] = $v;
            $tmp[] = "?";
        }
        
        $sql = "INSERT INTO ".$table." (".implode(', ', $key).") VALUES (".implode(', ', $tmp).")";
        $sth = VC::db()->prepare($sql);
        $sth->execute($val);
        
        return VC::db()->lastInsertId();
    }
    
    public static function DB_update($table, $data, $where, $and_or = 'AND') {
        $set = [];
        $val = [];
        foreach ($data as $k=>$v) {
            $set[] = "{$k}=?";
            $val[] = $v;
        }
        
        $whe = [];
        $whe_v = [];
        foreach ($where as $k=>$v) {
            $whe[] = $k."=?";
            $whe_v[] = $v;
        }
        
        $sql = "UPDATE ".$table." SET ".implode(', ', $set)." WHERE ".implode(' '.$and_or.' ', $whe)."";
        $sth = VC::db()->prepare($sql);
        $status = $sth->execute(array_merge($val,$whe_v));
        
        if (!$status) {
            throw new PublicException("Bład podczas wykonywania zapytania do bazy danych");
        }
    }
    
    public static function DB_delete($table, $where, $and_or = 'AND') {
        $whe = [];
        $whe_v = [];
        foreach ($where as $k=>$v) {
            $whe[] = $k."=?";
            $whe_v[] = $v;
        }
        
        $sql = "DELETE FROM ".$table." WHERE ".implode(' '.$and_or.' ', $whe)."";
        $sth = VC::db()->prepare($sql);
        $sth->execute($whe_v);
    }
    
    public static function setPage($pageNum, $perPage, $count) {
        if($pageNum>0) {
            $page = $pageNum-1;
        }
        else {
            $page = 0;
        }
        $set = [];
        $set['page'] = $pageNum;
        $set['second'] = $perPage;
        $set['first'] = $page*$perPage;
        $set['all'] = ceil($count/$perPage);
        $set['rows'] = $count;
        return $set;
    }
    
    public static function publicURL($link, $controller = '', $action = 'index', $params = []) {
        
        $url = "";
        
        if($controller) {
            $url = "/$link/$controller/$action";
            
            foreach($params as $key => $value) {
                $url .= "/$key/$value";
            }
        }
        else {
            $url = "/$link";
        }
        
        return $url;
    }
}