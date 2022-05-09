<?php
require 'includes/connection.php';
if(isset($_POST)){

    $array = [
        "id" => "",
        "question" => $_POST['question'],
        "subject" => $_POST['subject']
    ];

    function insertjson($array){
        return json_encode($array);
    }

    function insertmysql($con, $data){
        $stmt = $con->prepare("INSERT INTO questions VALUES(?,?,?)");
        $stmt->bindParam(1,$id);
        $stmt->bindParam(2,$question);
        $stmt->bindParam(3,$subject);

        $id = $data['id'];
        $question = $data['question'];
        $subject = $data['subject'];
        $stmt->execute();
    }
    function formjsonmysql($con, $array){
        $myjson = insertjson($array);
        $obj = json_decode($myjson,true);
        insertmysql($con,$obj);
    }
    formjsonmysql($con,$array);
}
?>