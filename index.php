<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Задание 2</h1>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "lab 8";

    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM Analysis";
    $result = $conn->query($sql);

    echo "<section id='table'>
            <h2>Анализы</h2>
            <table>
                <tr>
                    <th>ID анализа</th>
                    <th>Название</th>
                    <th>Себестоимость</th>
                    <th>Цена</th>
                    <th>Группа</th>
                </tr>";

    foreach ($result as $row) {
        echo "<tr>
                    <td>" . $row["an_id"] . "</td>
                    <td>" . $row["an_name"] . "</td>
                    <td>" . $row["an_cost"] . "</td>
                    <td>" . $row["an_price"] . "</td>
                    <td>" . $row["an_group"] . "</td>
                  </tr>";
    }

    echo "</table>
    </section>";

    $sql = "SELECT * FROM Groups";
    $result = $conn->query($sql);

    echo "<section id='table'>
            <h2>Группы</h2>
            <table>
                <tr>
                    <th>ID группы</th>
                    <th>Название</th>
                    <th>Температурный режим</th>
                </tr>";

    foreach ($result as $row) {
        echo "<tr>
                    <td>" . $row["gr_id"] . "</td>
                    <td>" . $row["gr_name"] . "</td>
                    <td>" . $row["gr_temp"] . "</td>
                  </tr>";
    }

    echo "</table>
    </section>";

    $sql = "SELECT * FROM Orders";
    $result = $conn->query($sql);

    echo "<section id='table'>
            <h2>Заказы</h2>
            <table>
                <tr>
                    <th>ID заказа</th>
                    <th>Дата и время</th>
                    <th>ID анализа</th>
                </tr>";

    foreach ($result as $row) {
        echo "<tr>
                <td>" . $row["ord_id"] . "</td>
                <td>" . $row["ord_datetime"] . "</td>
                <td>" . $row["ord_an"] . "</td>
            </tr>";
    }

    echo "</table>
    </section>";
    ?>

    <h1>Задание 3</h1>
    <?php
    $query = "SELECT an_name, an_price FROM Analysis ORDER BY an_price DESC LIMIT 5";
    $result = mysqli_query($conn, $query);

    echo "<h2>Самые дорогие анализы</h2>";
    foreach ($result as $row) {
        echo "{$row['an_name']} - ";
        echo "{$row['an_price']}<br>";
    }
    ?>
    <h1>Задание 4</h1>
    <?php
    $query = "SELECT gr_temp, COUNT(*) as count FROM Groups GROUP BY gr_temp ORDER BY count DESC LIMIT 1";
    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_assoc($result);
    $popularTemp = $row['gr_temp'];

    $queryAnalyses = "SELECT an_name FROM Analysis WHERE an_group IN (SELECT gr_id FROM Groups WHERE gr_temp = $popularTemp) LIMIT 7";
    $resultAnalyses = mysqli_query($conn, $queryAnalyses);


    echo "<h2>Температура: $popularTemp</h2>";

    foreach ($resultAnalyses as $row) {
        echo "{$row['an_name']}<br>";
    }
    ?>
    <h1>Задание 4</h1>
    <?php
    $query = "SELECT Orders.ord_id, Orders.ord_datetime, Analysis.an_name
              FROM Orders
              JOIN Analysis ON Orders.ord_an = Analysis.an_id";

    $result = mysqli_query($conn, $query);

    echo "<section id='table'>
            <h2>Заказы</h2>
            <table>
                <tr>
                    <th>ID заказа</th>
                    <th>Дата и время</th>
                    <th>Название анализа</th>
                </tr>";

    foreach ($result as $row) {
        echo "<tr>
                <td>" . $row["ord_id"] . "</td>
                <td>" . $row["ord_datetime"] . "</td>
                <td>" . $row["an_name"] . "</td>
            </tr>";
    }

    echo "</table>";
    ?>
    <h1>Задание 6</h1>
    <?php
    $query = "SELECT Analysis.an_name, Analysis.an_price
    FROM Orders
    JOIN Analysis ON Orders.ord_an = Analysis.an_id
    WHERE Orders.ord_datetime >= '2020-02-05' AND Orders.ord_datetime < '2020-02-12'";

    $result = mysqli_query($conn, $query);
    
    echo "<section id='table'>
            <h2>Заказы 5-12 февраля</h2>
            <table>
                <tr>
                    <th>Название анализа</th>
                    <th>Цена</th>
                </tr>";

    foreach ($result as $row) {
        echo "<tr>
                <td>" . $row["an_name"] . "</td>
                <td>" . $row["an_price"] . "</td>
            </tr>";
    }

    echo "</table>";

    mysqli_close($conn);
    ?>
</body>

</html>