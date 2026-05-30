<?php
require __DIR__ . '/inc/functions.inc.php';

$city = null;

if (!empty($_GET['city'])) {
    $city = $_GET['city'];
}

// var_dump($city);

$filename = null;

if (!empty($city)) {
    $cities = json_decode(
        file_get_contents(__DIR__ . '/../data/index.json'),
        true
    );

    foreach ($cities as $currentCity) {
        if ($currentCity['city'] === $city) {
            $filename = $currentCity['filename'];
            break;
        }
    }
    // var_dump($filename);
}

if (!empty($filename)) {
    $results = json_decode(
        file_get_contents('compress.bzip2://' . __DIR__ . '/../data/' . $filename),
        true
    )['results'];

    $stats = [];
    foreach ($results as $result) {
        if ($result['parameter'] !== 'pm25') continue;
        if ($result['value'] < 0) continue;
        // var_dump($result);

        $month = substr($result['date']['local'], 0, 7);
        if (!isset($stats[$month])) {
            $stats[$month] = [];
        }
        $stats[$month][] = $result['value'];
        // var_dump($stats);
        // var_dump($month);
        // break;
    }

    var_dump($stats);
}

?>

<?php require __DIR__ . '/views/header.inc.php'; ?>

<?php if (empty($city)) : ?>
    <p>The city could not be loaded.</p>
<?php else : ?>
    <?php if (!empty($stats)) : ?>
        <table>
            <?php foreach ($stats as $month => $measurements): ?>
                <tr>
                    <th><?php echo e($month); ?></th>
                    <td><?php echo e(array_sum($measurements) / count($measurements)); ?></td>
                </tr>
            <?php endforeach ?>
        </table>
    <?php endif; ?>
<?php endif; ?>

<?php require __DIR__ . '/views/footer.inc.php'; ?>