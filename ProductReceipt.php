<meta charset="UTF-8">
<title>Журнал поступления</title>
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
            <label for="candie">Журнал</label><br>
            <input class="inputStyle" type="text" name="candy_id" placeholder="Добавьте id конфеты" id="candy_id">
            <br>
            <input class="inputStyle" type="text" name="supplier_id" placeholder="Добавьте id поставщика" id="supplier_id">
            <br>
            <input class="inputStyle" type="text" name="amount" placeholder="Добавьте кол-во конфет" id="amount">
            <br>
            <input class="inputStyle" type="text" name="date_received" placeholder="Добавьте дату поступления" id="date_received">
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
    $stmt = $db->prepare("INSERT INTO ProductReceipt (candy_id, supplier_id, amount, date_received) VALUES (:candy_id, :supplier_id, :amount, :date_received)"); //Добавляем поставщика, номер телефона в БД
    $stmt -> execute(['candy_id'=>$_POST['candy_id'],'supplier_id' => $_POST['supplier_id'],'amount' => $_POST['amount'], 'date_received' => $_POST['date_received']]);
    $stmt = $db->prepare("ALTER TABLE ProductReceipt AUTO_INCREMENT=1");
    $stmt -> execute();
} catch(PDOException $e){
    // print('Error : ' . $e->getMessage());
    exit();
}

$search = 0;

if(!empty($_POST['search'])){
    try {
        $request = $_POST['search'];
        $stmt = $db->prepare("SELECT * FROM ProductReceipt WHERE candy_id LIKE '%$request%' or supplier_id like '%$request%' or amount LIKE '%$request%' or date_received LIKE '%$request%'"); //Запрашиваем из бд всех поставщиков
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
        $stmt = $db->prepare("SELECT * FROM ProductReceipt"); //Запрашиваем из бд всех поставщиков
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
            <th>candy_id</th>
            <th>supplier_id</th>
            <th>Количество</th>
            <th>Дата поступления</th>
        </tr>
    </thead>
    
    <tbody> 
        <?php foreach ($values as $row): //Выводим всх поставщиков?> 
            <form action="" method="POST">
                <tr>
                <td><?php print($row['id']); ?></td>
                <td><div class="inputTable"><input  class="inputStyleTable" type="text" name="candy_id<?php print($row['id']) ?>" value="<?php print($row['candy_id']); ?>" readonly="readonly"></div></td>
                <td><div class="inputTable"><input  class="inputStyleTable" type="text" name="supplier_id<?php print($row['id']) ?>" value="<?php print($row['supplier_id']); ?>" readonly="readonly"></div></td>
                <td><div class="inputTable"><input  class="inputStyleTable" type="text" name="amount<?php print($row['id']) ?>" value="<?php print($row['amount']); ?>"></div></td>
                <td><div class="inputTable"><input  class="inputStyleTable" type="text" name="date_received<?php print($row['id']) ?>" value="<?php print($row['date_received']); ?>"></div></td>
                <td><button type="submit" name="action" value="delete<?php print($row['id']) ?>"><img src="images/RedCross.png" alt="Error" title="Удалить"></button></td>
                <td><button type="submit" name="action" value="save<?php print($row['id']) ?>"><img src="images/GreenCheckMark.jpg" alt="Error"title="Сохранить"></button></td>
                </tr>
            </form>
        <?php endforeach; ?>    
           
           <?php
           if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if(strpos($_POST['action'], 'delete') !== false){ //Удаляем поставщика
                    try {
                        $stmt = $db->prepare("DELETE FROM ProductReceipt WHERE id = :id");
                        $id = str_replace('delete', "", $_POST['action']);
                        $stmt->bindParam(':id', $id);
                        $stmt -> execute();
                        $stmt = $db->prepare("ALTER TABLE ProductReceipt AUTO_INCREMENT=1");
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
                        $stmt = $db->prepare("UPDATE ProductReceipt SET candy_id = :candy_id, supplier_id = :supplier_id, amount = :amount, date_received = :date_received WHERE id = :id");
                        $stmt->bindParam(':id', $id);
                        $stmt->bindParam(':candy_id', $_POST['candy_id'.$id]);
                        $stmt->bindParam(':supplier_id', $_POST['supplier_id'.$id]);
                        $stmt->bindParam(':amount', $_POST['amount'.$id]);
                        $stmt->bindParam(':date_received', $_POST['date_received'.$id]);
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
