<meta charset="UTF-8">
<title>Конфеты</title>
<link rel="stylesheet" href="style/style.css">


<div class="Headings">
    <div class="Item-Headings">
        <a href="candies.php">Конфеты</a>
    </div>
    <div class="Item-Headings">
        <a href="suppliers.php">Поставщики</a>
    </div>
    <div class="Item-Headings">
        <a href="stores.php">Торговые точки</a>
    </div>
    <div class="Item-Headings">
        <a href="ProductReceipt.php">Журнал поступления</a>
    </div>
    <div class="Item-Headings">
        <a href="ProductRelease.php">Журнал отпуска</a>
    </div>
</div>
<div class="wrap">
    <div class="formWrap">
        <form id="formAdd" action="" method="POST" class="formStyle">
            <label for="candie">Конфета</label><br>
            <input class="inputStyle" type="text" name="candie" placeholder="Добавьте конфету" id="candie">
            <br>
            <input type="submit" value="Добавить" class="input-button inputStyle">
        </form>
        <form id="fordSearch" action="" method="POST" class="formStyle">
            <label for="search">Поиск</label><br>
            <input class="inputStyle" type="text" name="search" placeholder="Поиск по имени" id="search">
            <br>
            <input type="submit" value="Поиск" class="input-button inputStyle">
        </form>
    </div>
</div>

<?php //Подключаемся к БД
$user = 'root';
$pass = '';
$db = new PDO('mysql:host=localhost;dbname=myDB', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

try {
    $stmt = $db->prepare("INSERT INTO candies (name) VALUES (:candie)"); //Добавляем конфету в БД
    $stmt -> execute(['candie'=>$_POST['candie']]);
    $stmt = $db->prepare("ALTER TABLE candies AUTO_INCREMENT=1");
    $stmt -> execute();
} catch(PDOException $e){
    // print('Error : ' . $e->getMessage());
    exit();
}

$search = 0;

if(!empty($_POST['search'])){
    try {
        $request = $_POST['search'];
        $stmt = $db->prepare("SELECT id, name FROM candies WHERE name LIKE '%$request%'"); //Запрашиваем из бд все конфеты
        $stmt->execute();
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $search = 1;
    } catch (PDOException $e) {
        
        exit();
    }
}
else{
    $search = 0;
    try {
        $stmt = $db->prepare("SELECT id, name FROM candies"); //Запрашиваем из бд все конфеты
        $stmt->execute();
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        
        exit();
    }
}
?>


<div class="tableWrap">
    <table>
    <thead>
        <tr>
            <th>id</th>
            <th>Название</th>
        </tr>
    </thead>
    
    <tbody> 
        <?php foreach ($values as $row): //Выводим все конфеты?> 
            <form action="" method="POST">
                <tr>
                <td><?php print($row['id']); ?></td>
                <td><div class="inputTable"><input  class="inputStyleTable" type="text" name="name<?php print($row['id']) ?>" value="<?php print($row['name']); ?>"></div></td>
                <td><button type="submit" name="action" value="delete<?php print($row['id']) ?>"><img src="images/RedCross.png" alt="Error" title="Удалить"></button></td>
                <td><button type="submit" name="action" value="save<?php print($row['id']) ?>"><img src="images/GreenCheckMark.jpg" alt="Error"title="Сохранить"></button></td>
                </tr>
            </form>
        <?php endforeach; ?>    
           
           <?php
           if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if(strpos($_POST['action'], 'delete') !== false){ //Удаляем конфету
                    try {
                        $stmt = $db->prepare("DELETE FROM candies WHERE id = :id");
                        $id = str_replace('delete', "", $_POST['action']);
                        $stmt->bindParam(':id', $id);
                        $stmt -> execute();
                        $stmt = $db->prepare("ALTER TABLE candies AUTO_INCREMENT=1");
                        $stmt -> execute();
                        echo "<script>window.location.href = window.location.href;</script>";
                        exit();
                    } catch(PDOException $e){
                        // print('Error : ' . $e->getMessage());
                        exit();
                    }

                }
                if(strpos($_POST['action'], 'save') !== false){  //Изменяем конфету 
                    try{
                    $id = str_replace('save', "", $_POST['action']);
                    $stmt = $db->prepare("UPDATE candies SET name = :name WHERE id = :id");
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':name', $_POST['name'.$id]);
                    $stmt->execute();
                    echo "<script>window.location.href = window.location.href;</script>";
                        exit();
                    }catch(PDOException $e){
                        // print('Error : ' . $e->getMessage());
                        exit();
                    }

                }
            }
                
            ?>
    </tbody>
    </table>
</div>
