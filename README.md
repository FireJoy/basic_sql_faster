# Array Based sql faster
that's a simple php sql framework for write sql faster without sql text.just upload sql file in   database configure the config file and write small  code .
In shortwords It will save time and work for sql.



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
// ))); #select with where
