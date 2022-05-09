<?php
require 'includes/connection.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/src/css/style.css">
    <link rel="stylesheet" href="export.css" type="text/css" media="print">
    <title>Export</title>
</head>
<body>
<button onclick="window.print();" class="button_send" id="print-btn">Export</button>
<div class="container">
        <div class="container">
            <table>
                <tr>
                    <th>Answer</th>
                </tr>
                <?php
                $query = "SELECT * FROM answers ORDER BY id asc";
                $result = mysqli_query($con,$query);
                $record_arr = array();
                while($row = mysqli_fetch_array($result)){
                    $answer = $row['answers'];
                    $record_arr[] = array($answer);
                    ?>
                    <tr>
                        <td><?php echo $answer; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
</div>
</body>
</html>
