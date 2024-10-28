<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$url = 'http://lab.vntu.org/api-server/lab8.php?user=student&pass=p@ssw0rd';

$json_data = file_get_contents($url);

$data = json_decode($json_data, true); 

if (json_last_error() !== JSON_ERROR_NONE) {
    die('Error occurred while decoding JSON: ' . json_last_error_msg());
}

if (isset($data['status']) && $data['status'] === 'auth_fail') {
    die('Аутентифікація не вдалася. Будь ласка, перевірте свої облікові дані.');
}

$people = [];
foreach ($data as $group) {
    foreach ($group as $record) {
        $people[] = [
            'name' => $record['name'],
            'affiliation' => $record['affiliation'],
            'rank' => $record['rank'],
            'location' => $record['location'],
        ];
    }
}

?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Люди</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Список людей</h2>
<table>
    <thead>
        <tr>
            <th>Ім'я</th>
            <th>Приналежність</th>
            <th>Ранг</th>
            <th>Місцезнаходження</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($people as $person): ?>
            <tr>
                <td><?php echo htmlspecialchars($person['name']); ?></td>
                <td><?php echo htmlspecialchars($person['affiliation']); ?></td>
                <td><?php echo htmlspecialchars($person['rank']); ?></td>
                <td><?php echo htmlspecialchars($person['location']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>


