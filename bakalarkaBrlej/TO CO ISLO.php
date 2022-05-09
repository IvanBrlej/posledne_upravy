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
$pom = 0;
while(($row = mysqli_fetch_array($result))) {
    $arr = explode(',', $row['questions']);
    $type = $row['questionType'];
    foreach ($arr as $key => $value) {
        if($type == "checkbox"){
            ?>
            <?php
            echo "<div class='question container'>";
            ?>
            <input   class="inputQuestion" id="<?php echo "Question $i: ";?>" value="<?php echo   $value;?>">
            <input  class="inputAnswer" id="<?php echo "Answer $i: ";?>" placeholder="odpoved na otazku">

            <?php
            echo "</div>";
            $i++;
        }else{
            if($pom == 0){
                echo "<div class='questionText container'>";
                ?>
                <input  class="inputQuestionText" id="<?php echo "Question Text: ";?>" value="<?php echo   $value;?>">
                <input  class="inputAnswerText" id="<?php echo "Answer Text: ";?>" placeholder="odpoved na otazku">
                <?php
                $pom++;
                echo "</div>";
            }
        }
    }
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
    <input type="hidden" name="userLoggedIn" value="<?php echo $userLoggedIn; ?>">
    <input type="hidden" name="subject" value="<?php echo $subject; ?>">
    <div class="container">
        <div class="col-sm-10">
            <button type="submit"  class="sendTest" id="submitTest"  name="submitTest">Submit Test</button>
        </div>
    </div>
</div>
</body>
</html>

<script>
    $(document).ready(function(){
        $("#submitTest").click(function(){
            var array = document.getElementsByClassName('question');
            var arrayText = document.getElementsByClassName('questionText');
            var questions = [];
            for(let j = 0; j < array.length; j ++){
                var question = array[j].querySelector('input[class="inputQuestion"]').value;
                var answer = array[j].querySelector('input[class="inputAnswer"]').value;
                var result = {question: question, answer: answer};
                questions.push(result);
            }
            for(let j = 0; j < arrayText.length; j ++){
                var questionText = arrayText[j].querySelector('input[class="inputQuestionText"]').value;
                var answerText = arrayText[j].querySelector('input[class="inputAnswerText"]').value;
                var resultText = {questionText: questionText, answerText: answerText};
                questions.push(resultText);
            }
            $.ajax({
                url: 'JSONTEST_HANDLER.php',
                method: "post",
                data: {questions : JSON.stringify( questions )},
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

