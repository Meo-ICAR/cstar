<?php

if (function_exists('opcache_reset')) {
    echo opcache_reset() ? 'OpCache reset successful' : 'OpCache reset failed';
} else {
    echo 'OpCache is not enabled or function not available';
}
unlink(__FILE__);
