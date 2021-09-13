<?php

include 'koneksi.php';

session_start();
$_SESSION = [];
session_unset();
session_destroy();

mysqli_close($conn);
?>

<script>
    window.location='index.php';
</script>
<?php

?>