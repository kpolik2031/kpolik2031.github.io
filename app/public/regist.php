<?php  
include 'conect.php';
    $name = $connect->real_escape_string($_POST["first_name"]);
    $fam = $connect->real_escape_string($_POST["last_name"]);
    $age = $connect->real_escape_string($_POST["email"]);
    $proiz = $connect->real_escape_string($_POST["phone"]);
    $text = $connect->real_escape_string($_POST["ask"]);

    $sql = "INSERT INTO zaiavka (`first_name`, `last_name`, `email`, `phone` , `ask`) VALUES ('$name', '$fam', '$age', '$proiz', '$text')";
    if($connect->query($sql)){
        header('Location: /link.php');
        echo "Данные успешно добавлены  <a href=/cms/ctovar.php> Вернуться обратно</a>";
    } else{
        echo "Ошибка: " . $connect->error;
    }

    $connect->close();
?>
