<?php
$base="";
$environment="development";
$db=array(
    "host"=>"localhost",
    "user"=>"root",
    "password"=>"123456",
    "database"=>"lifo_fifo"
);

// pre defined variables

if(!function_exists("c")){
    function c($data){?><script>c(<?php echo $data; ?>);</script><?php 
     }
     //php console.log function
    
    
    ?>
    
    <script>
    function c(data){<?php if($environment=="development"){ ?> console.log(data); <?php } ?>}
    // javascript   console.log   function
    </script>
    
    <?php
    } // development user messaged done 
    


$conn=new mysqli($db["host"],$db["user"],$db["password"],$db["database"]);
if($conn->connect_error){
    c("Connection failed :".$conn->connect_error);
    exit();
}
// connect database


if(!function_exists("sql")){
function sql($arr=false){
if($arr && array_key_exists("task",$arr) && array_key_exists("table",$arr)){
    $conn=$GLOBALS['conn'];
    $table=$arr["table"];
    $task=$arr["task"];
    // additional veriables
    $exist=false;
    if(array_key_exists("id",$arr)){ $id=$arr["id"]; }
    if(array_key_exists("where",$arr)){ $where=$arr["where"]; }
    if(array_key_exists("update",$arr)){ $update=$arr["update"]; }
    if(array_key_exists("limit",$arr)){ $limit=$arr["limit"]; }
    if(array_key_exists("wild_card_keys",$arr)){ $wild_card_keys=$arr["wild_card_keys"]; }
    if(array_key_exists("wild_card_value",$arr)){ $wild_card_value=$arr["wild_card_value"]; }
    if(array_key_exists("sql_state",$arr)){ $sql_state=$arr["sql_state"]; }

    if(isset($update)|| isset($insert)){
        $temp_str=false;
       
        foreach($update as $item_key=>$item){
            if($temp_str){
                $temp_str.=",";
            }
            $temp_str.="`".$item_key."`='".$item."'";
        }
        $update=$temp_str;
        
        
    }
    // update/insert task formating
    
    if(isset($where)){
        $temp_str=false;
        foreach($where as $item_key=>$item){
            if(strpos($item,"_||")){
                $opt="OR";
            }
            else{
                $opt="AND";
            }
            if(!$temp_str){
                $temp_str=" WHERE ";
            }
            $item_f=str_replace(" _||",'',$item);
            $item_f=str_replace(" _&&",'',$item_f);
            $item_f=str_replace("_||",'',$item_f);
            $item_f=str_replace("_&&",'',$item_f);
            $temp_str.=" ".$item_key."='".$item_f."' ".$opt;
        }
        $where=" ".$temp_str." 1 ";
    }
    
    // extra veriables 
    if($task=="delete" || $task=="update"){
        if(isset($where)){
            $sql_text="SELECT * FROM `".$table."` WHERE `id`=".$id;
        }
        else{
            $sql_text="SELECT * FROM `".$table."`".$where;
        }
        $get_data = $conn->query($sql_text);
        if($get_data->num_rows > 0){
            $exist=true;
        }
        
    }
    // cheking is data exists or not

    if($task=="delete" && $exist){
        if(!isset($where)){$sql_text="DELETE FROM `".$table."` WHERE `id` = ".$id;}
        else{$sql_text="DELETE FROM ".$table.$where; }
        if($conn->query($sql_text)){
            $result=1;
        }
        else{
            $result=0;
        }
    }
    // function delete

    elseif($task=="update" && $exist|| $task=="insert"){
        if($task=="insert"){
            $sql_text="INSERT INTO ".$table." (id) VALUES (NULL);";
            if($conn->query($sql_text)){
                $id = $conn->insert_id;
            }
            else{
                $id = 0;
            }
        }
        // insert data
        if($id != 0){
            if(isset($where) && $task != "insert"){
                $sql_text="UPDATE ".$table." SET ".$update.$where;
            }
            else{
                $sql_text="UPDATE ".$table." SET ".$update." WHERE `id`=".$id;
            }
            if($conn->query($sql_text)){
                $result=1;
            }
            else{
                $result=0;
            }

        }
        else{
            echo 0;
        }
        // update data


    }
    // function insert or update
    elseif($task=="select"){
        if(isset($where)){
            $sql_text="SELECT * FROM `".$table."`".$where;
        }
        else{
            $sql_text="SELECT * FROM `".$table."`";
        }
       
        $temp_arr = $conn->query($sql_text);
        $temp_output=[];
        if ($temp_arr->num_rows > 0) {
            while($row = $temp_arr->fetch_assoc()) {
                array_push($temp_output,$row);
            }
            $result=$temp_output;
        } else {
            $result=0;
        }
    }
    else{
        $result=0;
    }
    // function update
    if(isset($sql_state) && $sql_state==true){
        if(!isset($sql_text)){
            $sql_text="task not found";
        }
        if(!isset($result)){
            $result=0;
        }
        if(true){

        }
        if(gettype($result)=="array" && isset($sql_state) && $sql_state==true){
            $result=json_encode($result);
            $result=preg_replace("/},/is",'},<br>',$result);
            $result="<br>".$result;
        } 
        $result="SQL: ".$sql_text." ; return:".$result.";";
    }
    // sql state
}
else{
    $result=0;
}
if(!isset($result)){
    $result=0;
}
return $result;
}
}// sql database array based















// test ground
// echo sql(array("id"=>"4","table"=>"users","task"=>"update","update"=>array("email"=>"joy","password"=>"hmm2"))); #update
// echo sql(array("id"=>"4","table"=>"users","task"=>"delete")); #delete
// echo sql(array("table"=>"users","task"=>"insert","update"=>array("email"=>"joy5","password"=>"hmm2"))); #insert
// print_r(sql(array("table"=>"users","task"=>"select"))); #select



// print_r(sql(array(
//     "table"=>"users",
//     "task"=>"select",
//     "where"=>array(
//         "OR"=>array(
//             ""
//         ),
//         "AND"=>array(
//             ""
//         )
//     )
// ))); #select


// print_r(sql(array(
//     "table"=>"users",
//     "task"=>"select",
//     "where"=>array(
//         "email"=>"joy3",
        
//     ),
//     "sql_state"=>true
// ))); #select