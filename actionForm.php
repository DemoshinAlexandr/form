<?php
// если пришли все необходимые для записи в базу данные
if ( isset($_POST["name"]) && isset($_POST["phone"]) && isset($_POST["email"]) && isset($_POST["question"]) &&
    isset($_POST["budget"]) && isset($_POST['product'])  && isset($_POST['ref'])) {

    // на всякий случай проверяем валидацию так же и на стороне сервера и сразу же отправляем предупреждение на страничку, проверяем что имя не пустое
    if (trim($_POST["name"]) == "") {
        $result = 'Имя не должно быть пустое';
        echo json_encode($result);
        exit;
    }

    //проверяем что бюджет это числовое поле
    if (trim($_POST["budget"]) != "" && !is_numeric($_POST["budget"])) {
        $result = 'Бюджет должен быть числом';
        echo json_encode($result);
        exit;
    }

    //проверяем что список не пустой
    if ($_POST["product"] == "0") {
        $result = 'Список не должен быть пустой';
        echo json_encode($result);
        exit;
    }

    //проверяем что телефон если не пустой, то удаляем все кроме цифр и если нужно, приписываем 8 в начале.
    if (trim($_POST["phone"]) != "") {
        $phone = $_POST["phone"];
        $phone = preg_replace('~[^0-9]+~', '', $phone);
        if ($phone[0] != 8 && strlen($phone) == 10) {
            $phone = '8' . $phone;
        }
    }
    else $phone = "";

    // если все нормально, подключаемся к базе
    require_once 'db.php';

    //используем подготовленный запрос для исключения инъекций
    try{
        $sql = 'INSERT INTO list SET
        name = :name,
        phone = :phone,
        email = :email,
        question = :question,
        budget = :budget,
        product_id = :product,
        ref = :ref';

        $s = $pdo->prepare($sql);
        $s->bindValue(':name', $_POST['name']);
        $s->bindValue(':phone', $phone);
        $s->bindValue(':email', $_POST['email']);
        $s->bindValue(':question', $_POST['question']);
        $s->bindValue(':budget', $_POST['budget']);
        $s->bindValue(':product', $_POST['product']);
        $s->bindValue(':ref', $_POST['ref']);
        $s->execute();

        $result = 'Yes';  // Yes если данные успешно добавлены
        echo json_encode($result);
    }
    catch (PDOException $e)
    {
        $result = 'Произошла ошибка при добавлении данных в базу';
        echo json_encode($result);
        exit;
    }
}
else{
    $result = 'Ошибка при отправке данных.';
    echo json_encode($result);
}

?>