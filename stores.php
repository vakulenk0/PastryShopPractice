<meta charset="UTF-8">
<title>Торговые точки</title>
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
            <label for="candie">Магазины</label><br>
            <input class="inputStyle" type="text" name="store" placeholder="Добавьте магазин" id="store">
            <br>
            <input class="inputStyle" type="text" name="adress" placeholder="Добавьте адресс" id="adress">
            <br>
            <input class="inputStyle" type="text" name="phone" placeholder="Добавьте телефон" id="phone">
            <br>
            <input type="submit" value="Добавить" class="input-button inputStyle">
        </form>
        <form id="fordSearch" action="" method="POST" class="formStyle">
            <label for="search">Поиск</label><br>
            <input class="inputStyle" type="text" name="search" placeholder="Введите запрос" id="search">
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
    $stmt = $db->prepare("INSERT INTO stores (name, adress, phone) VALUES (:name, :adress, :phone)"); //Добавляем поставщика, номер телефона в БД
    $stmt -> execute(['name'=>$_POST['store'],'adress' => $_POST['adress'],'phone' => $_POST['phone']]);
    $stmt = $db->prepare("ALTER TABLE suppliers AUTO_INCREMENT=1");
    $stmt -> execute();
} catch(PDOException $e){
    // print('Error : ' . $e->getMessage());
    exit();
}

$search = 0;

if(!empty($_POST['search'])){
    try {
        $request = $_POST['search'];
        $stmt = $db->prepare("SELECT * FROM stores WHERE name LIKE '%$request%' or adress like '%$request%' or phone LIKE '%$request%'"); //Запрашиваем из бд всех поставщиков
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
        $stmt = $db->prepare("SELECT * FROM stores"); //Запрашиваем из бд всех поставщиков
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
            <th>Магазин</th>
            <th>Адресс</th>
            <th>Телефон</th>
        </tr>
    </thead>
    
    <tbody> 
        <?php foreach ($values as $row): //Выводим всх поставщиков?> 
            <form action="" method="POST">
                <tr>
                <td><?php print($row['id']); ?></td>
                <td><div class="inputTable"><input  class="inputStyleTable" type="text" name="store<?php print($row['id']) ?>" value="<?php print($row['name']); ?>"></div></td>
                <td><div class="inputTable"><input  class="inputStyleTable" type="text" name="adress<?php print($row['id']) ?>" value="<?php print($row['adress']); ?>"></div></td>
                <td><div class="inputTable"><input  class="inputStyleTable" type="text" name="phone<?php print($row['id']) ?>" value="<?php print($row['phone']); ?>"></div></td>
                <td><button type="submit" name="action" value="delete<?php print($row['id']) ?>"><img src="images/RedCross.png" alt="Error" title="Удалить"></button></td>
                <td><button type="submit" name="action" value="save<?php print($row['id']) ?>"><img src="images/GreenCheckMark.jpg" alt="Error"title="Сохранить"></button></td>
                </tr>
            </form>
        <?php endforeach; ?>    
           
           <?php
           if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if(strpos($_POST['action'], 'delete') !== false){ //Удаляем поставщика
                    try {
                        $stmt = $db->prepare("DELETE FROM stores WHERE id = :id");
                        $id = str_replace('delete', "", $_POST['action']);
                        $stmt->bindParam(':id', $id);
                        $stmt -> execute();
                        $stmt = $db->prepare("ALTER TABLE stores AUTO_INCREMENT=1");
                        $stmt -> execute();
                        echo "<script>window.location.href = window.location.href;</script>";
                        exit();
                    } catch(PDOException $e){
                        // print('Error : ' . $e->getMessage());
                        exit();
                    }

                }
                if(strpos($_POST['action'], 'save') !== false){  //Изменяем поставщика
                    try{
                    $id = str_replace('save', "", $_POST['action']);
                    $stmt = $db->prepare("UPDATE stores SET name = :name, adress = :adress, phone = :phone WHERE id = :id");
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':name', $_POST['store'.$id]);
                    $stmt->bindParam(':adress', $_POST['adress'.$id]);
                    $stmt->bindParam(':phone', $_POST['phone'.$id]);
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
