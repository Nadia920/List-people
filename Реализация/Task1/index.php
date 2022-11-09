<!DOCTYPE html>
<html>
<head>
    <title>Список людей</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" type="text/css" th:href="@{css/style.css}"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
</head>
<body>
    <h2>Список людей</h2>
    <?php
    include 'people.php';
    include '../Task2/listPeople.php';
    $conn = mysqli_connect("localhost", "root", "1111", "people");
    if (!$conn) {
        die("Ошибка: " . mysqli_connect_error());
    }
    $sql = "SELECT * FROM basic_inf_people";
    if ($result = mysqli_query($conn, $sql)) {
        echo "<table><tr><th>ID</th><th>Имя</th><th>Фамилия</th><th>Дата рождения</th><th>Пол</th><th>Город рождения</th></tr>";
        foreach ($result as &$row) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["surname"] . "</td>";
            echo "<td>" . $row["date_of_birth"] . "</td>";
            echo "<td>" . $row["sex"] . "</td>";
            echo "<td>" . $row["city_оf_birth"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<p>Информация о новом человеке</p>";
        echo "<form method='POST' action='people.php'>
<label>Введите имя: <input type='text' id='namePeople' name='namePeople' required > </label>
<label for='surname'>Введите фамилию:</label>
<input type='text' id='surname' name='surname' required >
<label for='dateOfBirth'>Введите дату рождения в формате(только числа): месяц(2 цифры)/число(2 цифры)/год(4 цифры)</label>
<input type='text' id='dateOfBirth' name='dateOfBirth' placeholder='12/30/2002' required >
<label for='sex'>Введите пол человека <br> 0 - мужской <br> 1 - женский </label>
<input type='text' id='sex' name='sex' required >
<label for='cityOfBirth'>Введите город рождения человека</label>
<input type='text' id='cityOfBirth' name='cityOfBirth' required >
<input type='button' onclick='__saveInDB()' value='Сохранить человека в базу данных'>
</form>";
        echo "<form method='POST' action='people.php'>
<label for='id'>Введите id:</label>
<input type='text' id='id' name='id' required >
<input type='button' onclick='__deleteFromDBById()' value='Удалить человека из базы данных'>
</form>";
        mysqli_free_result($result);
    } else {
        echo "Ошибка: " . mysqli_error($conn);
    }
    mysqli_close($conn);
    ?>
</body>

</html>