<?php
include('includes/header.php');

if(isset($_POST['subject'])){
    $subject = $_POST['subject'];
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
    <title>Export</title>
</head>
<body>

<div class="container">
    <form method='post' action='export_handler.php'>
        <div class="container">
        <input type='submit' class="button_send" value='CSV' name='Export'>
            <a style="color: #1b1b1b; text-decoration: none"  type="submit" href="exportPDF_handler.php" class="button_send">PDF</a>
        <table>
            <tr>
                <th>Answer</th>
                <th>Time of submission</th>
            </tr>
            <?php
            $query = "SELECT * FROM answers WHERE subject = '$subject'  ORDER BY id asc";
            $result = mysqli_query($con,$query);
            $record_arr = array();
            while($row = mysqli_fetch_array($result)){
                $answer = $row['answers'];
                $time_of_submission = $row['time_of_submission'];
                $record_arr[] = array($answer);
                ?>
                <tr>
                    <td><?php echo $answer; ?></td>
                    <td><?php echo $time_of_submission; ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
        $serialize_record_arr = serialize($record_arr);
        ?>
        </div>
        <textarea name='export_data' style='display: none;'><?php echo $serialize_record_arr; ?></textarea>
    </form>
</div>
</body>
</html>
