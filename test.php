<?php

require "functions.php";
require "header.htm";

$sender = "alvin@otanga.co.ke";
$receiver = "jvn@mit";

?>

<button class="btn" onclick='livereceiver("<?php echo $sender; ?>", "<?php echo $receiver; ?>");'>PRESS</button>
