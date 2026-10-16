<?php
// Keep the old URL working while the public About page lives at the site root.
header('Location: ../about.php', true, 301);
exit;
