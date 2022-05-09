<?php
include("includes/header.php");

if(isset($_GET['subject'])) {
    $subject = $_GET['subject'];
}
else
{
    header("Location: http://localhost:63342/bakalarkaBrlej/homepage.php");
    exit();
}

$query = $con->prepare("SELECT * FROM questionjson where subject = ?");
$query->bind_param("s",$subject);
$query->execute();
$result = $query->get_result();

$arr = array();
$i = 0;
while(($row = mysqli_fetch_array($result))) {
    $arr = explode(',', $row['questions']);
    $type = $row['questionType'];
    echo "<div class='question container $type'>";
    foreach ($arr as $key => $value) {
        if($type == "checkbox"){
            ?>
            <input type="checkbox" name="option" class="inputQuestion" id="<?php echo "Question [$i]:";?>" value="<?php echo   $value;?>">
            <label for="<?php echo "Question [$i]:";?>"><?php echo   $value;?></label>
            <?php

            $i++;

        }else if($type == "text"){
                ?>
                <input  class="inputQuestionText" id="<?php echo "Question Text: ";?>" value="<?php echo   $value;?>">
                <input  class="inputAnswerText" id="<?php echo "Answer Text: ";?>" placeholder="odpoved na otazku">
                <?php
    }else if($type == "radius button"){
            ?>
            <input type="radio" name="optionRadiusButton" class="inputRadioQuestion" id="<?php echo "Question [$i]:";?>" value="<?php echo   $value;?>">
            <label for="<?php echo "Question [$i]:";?>"><?php echo   $value;?></label>
            <?php
            $i++;
        }
}
    echo "</div>";
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/src/css/style.css">
    <title>Test</title>
    <script
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
</head>
<body>
<div class="container" style="margin-top: 20px;">
    <input id="subject" type="hidden" name="subject" value="<?php echo $subject; ?>">
    <div class="container">
        <div class="col-sm-10">
            <button type="submit"  onclick="location.href='/bakalarkaBrlej/homepage.php'" class="sendTest" id="submitTest"  name="submitTest">Submit Test</button>
        </div>
    </div>
</div>
</body>
</html>

<script>
    $(document).ready(function(){
        $("#submitTest").click(function(){
            var array = document.getElementsByClassName('question');
            var questions = [];
            for(let j = 0; j < array.length; j ++){
                if(array[j].classList.contains('checkbox')){
                    var otazka = array[j].querySelectorAll('input[name="option"]');
                    for( let l = 0; l < otazka.length; l ++){
                        if (otazka[l].checked) {
                            var question = array[j].querySelector('input[class="inputQuestion"]').value;
                            var result = {questionCheckBox: question};
                            questions.push(result);
                        }
                    }
                }else if(array[j].classList.contains('text')){
                    var questionText = array[j].querySelector('input[class="inputQuestionText"]').value;
                    var answerText = array[j].querySelector('input[class="inputAnswerText"]').value;
                    var resultText = {questionText: questionText, answerText: answerText};
                    questions.push(resultText);
                }else{
                    var questionRadio = array[j].querySelectorAll('input[name="optionRadiusButton"]');
                    for( let l = 0; l < questionRadio.length; l ++){
                        if (questionRadio[l].checked) {
                            var questionR = array[j].querySelector('input[class="inputRadioQuestion"]').value;
                            var resultR = {questionRadiusButton: questionR};
                            questions.push(resultR);
                        }
                    }
                }
            }
            var subject = document.getElementById("subject").value;
            $.ajax({
                url: 'JSONTEST_HANDLER.php',
                method: "post",
                data: {questions, subject},
                success: function (res) {
                    console.log(res);
                }
                ,
                error: function (jqXHR, exception) {
                    console.log('Error occured!!');
                }
            });
        });
    });
</script>

