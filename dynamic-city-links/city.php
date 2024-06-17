<?php
require __DIR__ . '/inc/functions.inc.php';

$city = null;

if (!empty($_GET['city'])) {
    $city = $_GET['city'];
}

// var_dump($city);

if (!empty($city)) {
    // load
    // prepare the data
}

?>

<?php require __DIR__ . '/views/header.inc.php'; ?>

<?php if (empty($city)) : ?>
    <p>The city could not be loaded.</p>
<?php else : ?>
<?php endif; ?>

<?php require __DIR__ . '/views/footer.inc.php'; ?>