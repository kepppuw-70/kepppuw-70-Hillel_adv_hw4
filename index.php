
<h1>Homework_4.</h1>

<br>

<p><b>1) Напишите класс который с помощью магических методов будет делать манипуляции над строками.</b></p>
<p><b>Вызов класса должен быть следующий:</b></p>
<br>
<p><b>$stringFormater = new StringFormater();</b></p>
<p><b>$stringFormater->name = 'uSeRnaMe';</b></p>
<p><b>echo $stringFormater->name; // вывести USERNAME</b></p>

<?php

class StringFormater 
{
    protected $name;

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->name;
         }
    }

    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
           $this->name = strtoupper($value);
        }
    }
}

$stringFormater = new StringFormater();
$stringFormater->name = 'uSeRnaMe';
echo $stringFormater->name;

?>

<br><br>

<p><b>2) Напишите класс который умеет заменять в строке пробелы на знак +, а строку приводить в нижний регистр . Вызов должен быть следующий:</b></p>
<p><b>$concatenated = Concatenator::prepareString('I am concatenated');</b></p>
<p><b>echo $concatenated; // i+am+concatenated</b></p>

<?php

class Concatenator 
{
    public static function prepareString($string)
    {
      return strtolower(strtr($string, ' ', '+'));
    }
}

$concatenated = Concatenator::prepareString('I am concatenated');
echo $concatenated;

?>

<br><br>

<p><b>3) Напишите класс который будет фильтровать массив путем удаления его элементов. Только с использованием магических методов!. Вызов класса будет такой:</b></p>
<p><b>$filter = new Filter(['f', 2, 't', 7, 2, 'k']);</b></p>
<p><b>$filter->getNumbers(); //[2,7,2]</b></p>
<p><b>$filter->getStrings(); // ['f', 't', 'k']</b></p>

<?php

class Filter
{

  protected $arr = [];
  protected $arrNumbers = [];
  protected $arrStrings = [];
    
   public function __construct($arr)
  {
      $this->arrNumbers = $arr;
      $this->arrStrings = $arr;
  }

  public function getNumbers()
  {
    foreach ($this->arrNumbers as $key => $value) {
       if (gettype($value) != 'integer') {
           unset($this->arrNumbers[$key]);
      }
    }
    echo '<b>[';
    $num = count($this->arrNumbers);
    $i = 0; 
    foreach ($this->arrNumbers as $key => $value) {
      $i++;
      if ($i < $num) {
        echo $value . ', ';
      } else {
        echo $value;
      }
    }
    echo ']</b><br>';
  }
 
  public function getStrings()
  {
     foreach ($this->arrStrings as $key => $value) {
       if (gettype($value) == 'integer') {
          unset($this->arrStrings[$key]);
       }
     }
     echo '<b>[';
     $num = count($this->arrStrings);
     $i = 0; 
     foreach ($this->arrStrings as $key => $value) {
        $i++;
        if ($i < $num) {
            echo "'" . $value . "'" . ', ';
        } else {
            echo "'" . $value . "'";
      }
    }
    echo ']</b><br>';
  }
}

$filter = new Filter(['f', 2, 't', 7, 2, 'k']);
$filter->getNumbers();
$filter->getStrings();

?>

<br><br>

<p><b>4) Напишите небольшое приложение которое будет проверять данные которые были введены с формы. Ваша логика должна использовать исключения и бросать:</b></p>
<p><b>а) исключение EmptyStringException если в поле вводе была передана пустая строка</b></p>
<p><b>б) исключение InvalidInputTypeException если данные были введены с неправильным типом (например число вместо строки)</b></p>
<p><b>Оформите валидатор как класс и подключите его в ваш обработчик формы. Вывод ошибок на ваше усмотрение.</b></p>

<br><br>

<?php

class UserException extends Exception { }

class EmptyStringException extends UserException
{
    protected $message = 'Error: empty';
}

class InvalidPasswordLongException extends UserException
{
  protected $message = 'Error: long password';
}

class User
{
  public $login;
  public $password;

  public function __construct($login, $password)
  {
    $this->login = $login;
    $this->password = $password;
  }

  public function addUser()
  {
    if (empty($this->login) || empty($this->password)) {
        throw new EmptyStringException;
    }

    if (strlen($this->password) < 8) {
      throw new InvalidPasswordLongException;
    }
    
    return true;
    
  }

}

try {
    $login = $_POST['login'];
    $password = $_POST['password']; 
    $user = new User($login, $password);
    $user->addUser();
    echo '<b>Login and password - ok!</b>';
} catch (UserException $e) {
      //die($e->getMessage());
      echo '<b>' . $e->getMessage() . '</b>';
}


?>

<br><br>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Form</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
  
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <form action="index.php" method="post">
          <div class="form-group">
            <label for="login">Логин</label>
            <input type="text" class="form-control" id="login" name="login">
          </div>
          <div class="form-group">
           <label for="passord">Пароль(не меньше 8 символов)</label>
            <input type="password" class="form-control" id="password" name="password">
          </div>
          <button type="submit" class="btn btn-default">Отправить</button>
        </form>
      </div>
    </div>
  </div>


</body>
</html>


