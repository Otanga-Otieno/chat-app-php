<?php

require "functions.php";
require "header.htm";

?>

<script>
    livereceiver("<?php echo $_SESSION['user']; ?>");
</script>
<button class="btn">PRESS</button>