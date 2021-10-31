<?php
namespace Database;

use PDO;

class QueryBuilder {

    protected $pdo;
    
    public function __construct($pdo )
    {   
        $this->pdo = $pdo;
    }


    public function getAll($table)
    { 
        $sql="SELECT * FROM {$table}";
        $statement=$this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }




    public function delete($table, $id)
    {
        $sql = "DELETE FROM {$table} WHERE id=:id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        //$statement->bindParam(':id', $id);//принимает только переменную ввкести строку или цифру нельзя
        $statement->execute();      
    }

    
    
    //запрос одной записи из нескольких таблиц
    public function getWhereTableAll($tables, $value, $where_param, $where_param_2, $table_param,$table_param_2,$join ,$where_param_3)
    {
        //$table_param - параметр из присоединяемой таблицы (user_id, post_id, и т д)
        //$table_param_2 - параметр из основной таблицы (users.id, posts.id и т д)
        //$where_param - условие выборки из таблицы (user_id, post_id, и.т.п)
        //$where_param_2 - значение условия выборки из таблицы (например id)
        //образец формируемого запроса - $sql = "SELECT * FROM users  INNER JOIN infos ON infos.user_id = users.id   INNER JOIN posts ON posts.user_id = users.id WHERE posts.id LIKE :id"
        $str = 'SELECT * FROM ' .$tables[0];
        foreach(array_slice($tables, 1) as $table){    
            $str .= '  INNER JOIN ' .$table. ' ON '. $table.'.'.$table_param.'  = '.$table_param_2;
        }
        $sql = $str .$join.' WHERE '.array_pop($tables).'.'.$where_param.' LIKE :'.$where_param_2.$where_param_3;
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':'.$where_param_2, $value);
        //$statement->bindParam(':id', $id);//принимает только переменную ввести строку или цифру нельзя
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }





    //запрос одной записи из нескольких таблиц  по двум параметрам !!!!пока не работает  и не нужна
    public function getWhereTableAllTwoParam($tables, $value, $where_param, $where_param_2, $table_param,$table_param_2,$where_param_3,$where_param_4 )
    {
        //$table_param - параметр из присоединяемой таблицы (user_id, post_id, и т д)
        //$table_param_2 - параметр из основной таблицы (users.id, posts.id и т д)
        //$where_param - условие выборки из таблицы (user_id, post_id, и.т.п)
        //$where_param_2 - значение условия выборки из таблицы (например id)
        //образец формируемого запроса - $sql = "SELECT * FROM users  INNER JOIN infos ON infos.user_id = users.id   INNER JOIN posts ON posts.user_id = users.id WHERE posts.id LIKE :id"
        $str = 'SELECT * FROM ' .$tables[0];
        foreach(array_slice($tables, 1) as $table){    
            $str .= '  INNER JOIN ' .$table. ' ON '. $table.'.'.$table_param.'  = '.$table_param_2;
        }
        $sql = $str .' WHERE '.array_pop($tables).'.'.$where_param.' LIKE :'.$where_param_2. ' AND '.$where_param_3.' LIKE '.$where_param_4;
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':'.$where_param_2, $value);
        $statement->bindValue(':'.$where_param_3, $where_param_4);
        //$statement->bindParam(':id', $id);//принимает только переменную ввести строку или цифру нельзя
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }




    //получение всех записей из нескольких таблиц  дополнительными условиями
    public function getAllTableAll($tables,$table_param,$table_param_2, $join , $where_param_3){
        //$table_param - параметр из присоединяемой таблицы (user_id, post_id, и т д)
        //$table_param_2 - параметр из основной таблицы (users.id, posts.id и т д)
        //образец формируемого запроса - $sql = "SELECT * FROM users  INNER JOIN infos ON infos.user_id = users.id   INNER JOIN posts ON posts.user_id = users.id"
        $sql = 'SELECT * FROM ' .$tables[0];
        foreach(array_slice($tables, 1) as $table){    
            $sql .= '  INNER JOIN ' .$table. ' ON '. $table.'.'.$table_param.'  = '.$table_param_2;
        }
        $sql = $sql.$join.$where_param_3;
        $statement=$this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }




    //получение всех записей из нескольких таблиц  дополнительными условиями
    public function getTableAll($tables,$table_param,$table_param_2){
        //$table_param - параметр из присоединяемой таблицы (user_id, post_id, и т д)
        //$table_param_2 - параметр из основной таблицы (users.id, posts.id и т д)
        //образец формируемого запроса - $sql = "SELECT * FROM users  INNER JOIN infos ON infos.user_id = users.id   INNER JOIN posts ON posts.user_id = users.id"
        $sql = 'SELECT * FROM ' .$tables[0];
        foreach(array_slice($tables, 1) as $table){    
            $sql .= '  INNER JOIN ' .$table. ' ON '. $table.'.'.$table_param.'  = '.$table_param_2;
        }
        $statement=$this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }





    //получение записей из любой одной таблицы с сортировкой 
    public function getTableParams($table,$value,$param_value,$param_where,$param_order,$param_sort){   
        $sql = "SELECT * FROM {$table} WHERE {$param_where}={$param_value} ORDER BY {$param_order} {$param_sort}";
        $statement=$this->pdo->prepare($sql);
        $statement->bindValue($param_value, $value);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }





    //получение одной записи по любому условию(полю) из любой одной таблицы
    public function getAllParam($table,$param,$value)
    {
        $sql = "SELECT * FROM {$table} WHERE {$param}=:{$param}";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':'.$param.'', $value);
        //$statement->bindParam(':id', $id);//принимает только переменную ввести строку или цифру нельзя
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }




    //получение одной записи по любому условию(полю) из любой одной таблицы
    public function getOneParam($table,$param,$value)
    {
        $sql = "SELECT * FROM {$table} WHERE {$param}=:{$param}";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':'.$param.'', $value);
        //$statement->bindParam(':id', $id);//принимает только переменную ввести строку или цифру нельзя
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }




     //получение одной записи по двум  условиям(полям) из любой одной таблицы
     public function getOneParamTwo($table,$param,$param2,$value,$value2)
     {
         $sql = "SELECT * FROM {$table} WHERE {$param}=:{$param} AND {$param2}=:{$param2}";
         //$sql = "SELECT * FROM {$table} WHERE {$param}= {$value} AND {$param2}={$value2}";
         $statement = $this->pdo->prepare($sql);
         $statement->bindValue(':'.$param.'', $value);
         $statement->bindValue(':'.$param2.'', $value2);
         //$statement->bindParam(':id', $id);//принимает только переменную ввести строку или цифру нельзя
         $statement->execute();
         return $statement->fetchAll(PDO::FETCH_ASSOC);
     }




     //получение одной записи по трем  условиям(полям) из любой одной таблицы
     public function getOneParamThree($table,$param,$param2,$param3,$value,$value2,$value3)
     {
         $sql = "SELECT * FROM {$table} WHERE {$param}=:{$param} AND {$param2}=:{$param2} AND {$param3}=:{$param3}";
         $statement = $this->pdo->prepare($sql);
         $statement->bindValue(':'.$param.'', $value);
         $statement->bindValue(':'.$param2.'', $value2);
         $statement->bindValue(':'.$param3.'', $value3);
         //$statement->bindParam(':id', $id);//принимает только переменную ввести строку или цифру нельзя
         $statement->execute();
         return $statement->fetch(PDO::FETCH_ASSOC);
     }
    




    //обновление в любой таблице
    public function updateAny($table, $data, $param, $param2)
    {    
        $keys = array_keys($data);
        $string = '';
        foreach($keys as $key)
        {
            $string .= $key .'=:'. $key .',';
        }
        $keys = rtrim($string, ',');
        $data['param2'] = $param2;
        $sql = "UPDATE {$table} SET {$keys} WHERE {$param}=:param2";
        $statement = $this->pdo->prepare($sql);
        foreach($data as $key => $value){
            $statement->bindValue(':'.$keys.'', $value);
        }
        $statement->bindValue(':param2', $param2);
        $statement->execute($data);
    }






    //обновление в любой таблице по двум условиям
    public function updateAnyTwoParam($table, $data, $param, $param2,$param3,$param4)
    {    
        $keys = array_keys($data);
        $string = '';
        foreach($keys as $key)
        {
            $string .= $key .'=:'. $key .',';
        }
        $keys = rtrim($string, ',');
        $data['param2'] = $param2;
        $data['param4'] = $param4;
        $sql = "UPDATE {$table} SET {$keys} WHERE {$param}=:param2 AND {$param3}=:param4";
        $statement = $this->pdo->prepare($sql);
        foreach($data as $key => $value){
            $statement->bindValue(':'.$keys.'', $value);
        }
        $statement->bindValue(':param2', $param2);
        $statement->bindValue(':param4', $param4);
        $statement->execute($data);
    }
    




    //удаление записи в любой таблице по двум параметрам
    public function deleteTwoParam($table,$param, $param2,$value,$value2)
    {
        $sql = "DELETE FROM {$table} WHERE {$param}=:{$param} AND {$param2}=:{$param2}";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':'.$param.'', $value);
        $statement->bindValue(':'.$param2.'', $value2);
        //$statement->bindParam(':id', $id);//принимает только переменную, ввести строку или цифру нельзя
        $statement->execute();    
    }





    //удаление записи в любой таблице
    public function deleteParam($table,$param, $value)
    {
        $sql = "DELETE FROM {$table} WHERE {$param}=:{$param}";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':'.$param.'', $value);
        //$statement->bindParam(':id', $id);//принимает только переменную ввкести строку или цифру нельзя
        $statement->execute();    
    }





    //новая запись в любую таблицу
    public function create($table,$data)
    {
        // модель запроса $sql = "INSERT INTO users (name, email, password) VALUE (:name, :email, :password)";
        $keys = implode(', ', array_keys($data));
        $tags = ":" . implode(', :',array_keys($data));
        $sql = "INSERT INTO {$table} ({$keys}) VALUE ({$tags})";
        $statement = $this->pdo->prepare($sql);
        foreach($data as $key => $value){
            $statement->bindValue(':'.$keys.'', $value);
        }
        $result = $statement->execute($data);
        return $result;
    }





    // получение id последней записи в таблицу
    public function lastId(){
        return $this->pdo->lastInsertId();
    }




    //получение количества записей в таблице
    public function countColumn($table){
        
        $sql = "SELECT COUNT(id) FROM {$table}";
        $statement = $this->pdo->query($sql);
        return $statement->fetchColumn();
    }


    
    //запрос по условиям пагинации
    public function getUsersListPaginate($tables, $params)
    { 
        $str = 'SELECT * FROM ' .$tables[0];
        foreach(array_slice($tables, 1) as $table){
            
            $str .= '  INNER JOIN ' .$table. ' ON '. $table.'.user_id  = users.id ';
        }
        $sql = $str .'  LIMIT ' .$params['start']. ','.$params['max'];
        $statement=$this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);    
    }




    //запрос по условиям пагинации  с параметром отбора
    public function getCommentsListPaginate($tables, $params,$where,$value)
    { 
        $str = 'SELECT * FROM ' .$tables[0];
        foreach(array_slice($tables, 1) as $table){
            
            $str .= '  INNER JOIN ' .$table. ' ON '. $table.'.user_id  = users.id  ';
        }
        $sql = $str .'WHERE '.$where.' = :'.$where.' LIMIT ' .$params['start']. ','.$params['max'];
        $statement=$this->pdo->prepare($sql);
        $statement->bindValue(':'.$where.'', $value);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);    
    }

}