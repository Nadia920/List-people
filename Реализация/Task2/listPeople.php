<?php
  include 'index.php';
if (class_exists('People')) {
    class ListPeople
    {
        private $arrayId = [];
        function __construct()
        {//Конструктор ведет поиск id людей по всем полям БД (поддержка выражений больше, меньше, не равно); 
            $conn = mysqli_connect("localhost", "root", "1111", "people");
            if (!$conn) {
            die("Ошибка: " . mysqli_connect_error());
            }
            $sql = "SELECT id FROM basic_inf_people";
            if ($result = mysqli_query($conn, $sql)) {
                $this->$arrayId = $result;
            } else {
            echo "Ошибка: " . mysqli_error($conn);
            }
            mysqli_close($conn);
        } 
        function __getPeople()
        { //Получение массива экземпляров класса 1 из массива с id людей полученного в конструкторе;
                $arrayPeople=[];
                for($i=0; $i<count(People::$_instances); $i++){
                    if(People::$_instances[$i]->id == arrayId[$i]){
                        $arrayPeople = People::$_instances[$i];
                    }

                }

        } 
        function __deletePeople()
        {//Удаление людей из БД с помощью экземпляров класса 1 в соответствии с массивом, полученным в конструкторе. 
            $conn = mysqli_connect("localhost", "root", "1111", "people");
            if (!$conn) {
            die("Ошибка: " . mysqli_connect_error());
            }
            foreach ($arrayId as &$id) {
                $sql = "DELETE FROM basic_inf_people WHERE id = " + $id;
                if($result = mysqli_query($conn, $sql)){} else {echo "Ошибка при получении информации из базы данных";}
            }
        } 
    }
} else {
    ini_set('error_reporting', E_ALL);
    error_reporting(-1);
}
?>
