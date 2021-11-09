<?php

require "functions.php";
require "header.htm";

$sender = "alvin@otanga.co.ke";
$receiver = "jvn@mit";

?>

<script>
    livereceiver("<?php echo $sender; ?>", "<?php echo $receiver; ?>")
</script>
