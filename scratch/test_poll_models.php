<?php
$modelsRes = @file_get_contents('https://image.pollinations.ai/models');
echo "Pollinations Image Models: " . $modelsRes . "\n";
