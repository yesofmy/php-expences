<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$period = isset($_GET['period']) ? $_GET['period'] : 'month';
$period_condition = "";

switch ($period) {
    case 'day':
        $period_condition = "AND date = CURDATE()";
        break;
    case 'week':
        $period_condition = "AND YEARWEEK(date, 1) = YEARWEEK(CURDATE(), 1)";
        break;
    case 'month':
        $period_condition = "AND MONTH(date) = MONTH(CURDATE()) AND YEAR(date) = YEAR(CURDATE())";
        break;
    case 'year':
        $period_condition = "AND YEAR(date) = YEAR(CURDATE())";
        break;
    default:
        $period_condition = "";
        break;
}


$sql = "SELECT category, SUM(amount) AS total 
        FROM expenses 
        WHERE user_id = $user_id $period_condition
        GROUP BY category";

$result = $conn->query($sql);

$categories = [];
$totals = [];

while ($row = $result->fetch_assoc()) {
    $categories[] = $row['category'];
    $totals[] = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Статистика витрат</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h2>Статистика витрат</h2>

        <form method="GET" action="statistics.php" class="period-form">
            <label for="period">Період:</label>
            <select name="period" id="period">
                <option value="day" <?php if ($period=='day') echo 'selected'; ?>>День</option>
                <option value="week" <?php if ($period=='week') echo 'selected'; ?>>Тиждень</option>
                <option value="month" <?php if ($period=='month') echo 'selected'; ?>>Місяць</option>
                <option value="year" <?php if ($period=='year') echo 'selected'; ?>>Рік</option>
            </select>
            <button type="submit">Показати</button>
        </form>

        <canvas id="pieChart" width="400" height="400"></canvas>

        <p><a href="dashboard.php">⬅ Назад до панелі</a></p>
    </div>

    <script>
        const ctx = document.getElementById('pieChart');

        const data = {
            labels: <?php echo json_encode($categories); ?>,
            datasets: [{
                label: 'Сума витрат',
                data: <?php echo json_encode($totals); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(255, 159, 64, 0.6)',
                    'rgba(120, 200, 100, 0.6)'
                ],
                borderColor: 'white',
                borderWidth: 2
            }]
        };

        new Chart(ctx, {
            type: 'pie',
            data: data,
            options: {
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: '#333',
                            font: {
                                size: 14
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Розподіл витрат за категоріями',
                        font: {
                            size: 18
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
