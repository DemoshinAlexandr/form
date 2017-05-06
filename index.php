<?php require_once 'db.php'; ?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Форма</title>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
  <script src="ajax.js"></script>
  <style type="text/css">
       textarea {
          display: block;
          width: 50%;
       }
       div {
          margin: 5px;
       }
  </style>
</head>
<body>
    <form method="post" id="ajax_form" action="" >
        <div>
            <label for="name">Ваше имя</label>
            <input type="text" id="name" name="name" required="required"/>
        </div>
        <div>
            <label for="phone">Телефон</label>
            <input type="tel" id="phone" name="phone" required="required"/>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required="required"/>
        </div>
        <div>
            <label for="question">Задайте Ваш вопрос</label>
            <textarea id="question" name="question" rows="5" cols="10"></textarea>
        </div>
        <div>
            <label for="budget">Каков Ваш бюджет (рубли)</label>
            <input type="text" id="budget" name="budget" required="required"/>
        </div>
        <div>
            <label for="product">Выберите продукт</label>
            <select name="product" id="product">
                <option value="0"></option>;
                <?php
                $s = $pdo->prepare("SELECT * FROM products ORDER BY Rating");
                $s->execute();
                $results = $s->fetchAll();
                foreach ($results as $result){
                    echo '<option value="'.$result['id'].'">'.$result['rating'].' '.$result['name'].'</option>';
                }
                ?>
            </select>
        </div>
        <div>
            <input type="hidden" id="ref" name="ref" value="<?php if (isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER']; else echo ''; ?>">
        </div>
        <div>
            <input type="button" id="btn" value="Отправить" />
        </div>
    </form>
    <br>
    <div id="result"><div>
</body>
</html>