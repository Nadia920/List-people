<?php
class People{
    private $id;//id
    private $name;//имя
    private $surname;//фамилия
    private $dateOfBirth;//дата рождения
    private $sex;//пол(0,1)
    private $cityOfBirth;// город рождения
    protected static $_instances = array();
    public function __saveInDB(){// Сохранение полей экземпляра класса в БД;
    $name = mysql_escape_string($_POST['name']);
    $surname= mysql_escape_string($_POST['surname']);
    $dateOfBirth= mysql_escape_string($_POST['dateOfBirth']);
    $sex= mysql_escape_string($_POST['sex']);
    $cityOfBirth= mysql_escape_string($_POST['cityOfBirth']);
    new People($name, $surname, $dateOfBirth, $sex, $cityOfBirth);
    $strSQL = "INSERT INTO basic_inf_people (name, surname, date_of_birth, sex, city_of_birth) values ($name,$surname,$dateOfBirth,$sex,$cityOfBirth)";
    mysql_query($strSQL) or die (mysql_error());
    mysql_close();
    }
    public function __deleteFromDBById(){//Удаление человека из БД в соответствии с id объекта; 
        if(isset($_POST["id"]))
        {
            $conn = mysqli_connect("localhost", "root", "1111", "people");
            if (!$conn) {
              die("Ошибка: " . mysqli_connect_error());
            }
            $userid = mysqli_real_escape_string($conn, $_POST["id"]);
            $sql = "DELETE FROM basic_inf_people WHERE id =" + $userid;
            if(mysqli_query($conn, $sql)){
                header("Location: index.php");
            } else{
                echo "Ошибка: " . mysqli_error($conn);
            }
            mysqli_close($conn);    
        }
    }
    public static function __convertingDateOfBirthToAge($infDateOfBirth){// static преобразование даты рождения в возраст (полных лет)
        return $age = $infDateOfBirth->diff(new DateTime)->format('%y');
    }
    public static function __genderConversionFromBinaryToText($infSex){//static преобразование пола из двоичной системы в текстовую (муж, жен)
        $gender;
        if($infSex == 0){
            $gender = 'муж';
        }
        else {$gender = 'жен';}
        return $gender;
    }
    public function __construct($initId=-1, $initName, $initSurname, $initDateOfBirth, $initSex, $initCityOfBirth){//Конструктор класса либо создает человека в БД с заданной информацией, либо берет информацию из БД по id (предусмотреть валидацию данных);
        
        
        if($initId!=-1){
            
                $conn = mysqli_connect("localhost", "root", "1111", "people");
                if (!$conn) {
                  die("Ошибка: " . mysqli_connect_error());
                }
                $data = mysqli_query("SELECT * FROM basic_inf_people WHERE id = " + $initId);
                $this->id=$data["id"];
                $this->name=$data["name"];
                $this->surname=$data["surname"];
                $this->dateOfBirth=$data["date_of_birth"];
                $this->sex=$data["sex"];
                $this->cityOfBirth=$data["city_оf_birth"];
            }
        else{
            if (preg_match("/^(0[1-9]|1[0-2])/(0[1-9]|[1-2][0-9]|3[0-1])/[0-9]{4}$/", $newDateOfBirth)) {
                if($initSex == 0 || $initSex == 1){
                    $conn = mysqli_connect("localhost", "root", "1111", "people");
                    if (!$conn) {
                      die("Ошибка: " . mysqli_connect_error());
                    }
                    $sql = "SELECT * FROM basic_inf_people";
                    $result = mysqli_query($conn, $sql);
                $this->var_dump(count($result));
                $this->name=$initName;
                $this->surname=$initSurname;
                $this->dateOfBirth=$initDateOfBirth;
                $this->sex=$initSex;
                $this->cityOfBirth=$initCityOfBirth;
                }
                else { echo "Ошибка. Проверьте, пожалуйста, выбранный пол человека" ;}
            }
            else { echo "Ошибка. Проверьте, пожалуйста, корректность введённой даты рождения" ;}
            
        }
        self::$_instances[] = $this;
    }
    public function __destruct()
    {
        unset(self::$_instances[array_search($this, self::$_instances, true)]);
    }
    public function __format($newId, $newName, $newSurname, $newDateOfBirth, $newSex, $newCityOfBirth){//Форматирование человека с преобразованием возраста и (или) пола (п.3 и п.4) в зависимотси от параметров (возвращает новый экземпляр StdClass со всеми полями изначального класса)
    if (preg_match("/^(0[1-9]|1[0-2])/(0[1-9]|[1-2][0-9]|3[0-1])/[0-9]{4}$/", $newDateOfBirth)) {
    $part = strtok($newDateOfBirth, '/');
    if(var_dump(checkdate(part[0], part[1], part[2]))){
        $age_new = __convertingDateOfBirthToAge($newDateOfBirth);
    }
    else {echo 'Такой даты не существует'; return;}
    if($newSex==0 || $newSex==1){
        $gender = __genderConversionFromBinaryToText($newSex);
        return new class($newId, $newName, $newSurname, $age_new, $gender, $newCityOfBirth);
    }
    else{  return new class($newId, $newName, $newSurname, $age_new, $newSex, $newCityOfBirth)}
    } else {
    if($newSex==0 || $newSex==1){
        $gender = __genderConversionFromBinaryToText($newSex);
        return new class($newId, $newName, $newSurname, $newDateOfBirth, $gender, $newCityOfBirth);
    }
    else{
        return new class($newId, $newName, $newSurname, $newDateOfBirth, $newSex, $newCityOfBirth);
    }
}
    } 
 } 

 ?>