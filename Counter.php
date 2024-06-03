<?php

declare(strict_types=1);

$folderName = "./";

print_r(summOfCounts($folderName));

/**
 * Ищет файлы по имени count во всех папках и подпапках и считает сумму всех их чисел
 * @param  string  $folderName - путь до папки
 * @param  float|null  $count  - сумма чисел из всех искомых файлов
 * @return float.
 */
function summOfCounts($folderName, $count = 0)
{
    $folderName = rtrim($folderName, '/');

    $dir = opendir($folderName);

    while(($file = readdir($dir)) !== false){
        $filePath = "$folderName/$file";

        if ($file === '.' || $file === '..') {
            continue;
        }

        if (is_file($filePath) && "count" === pathinfo($filePath)['filename'])
        {
            countNumbersInFile($filePath, $count);
        }
        if (is_dir($filePath)) {
            $count = summOfCounts($filePath, $count);
        }

    }

    closedir($dir);

    return $count;
}

/**
 * Считает сумму чисел, записанных через запятую или пробел из файла
 * @param string $filePath - путь до файла
 * @param float $count - сумма чисел
 * @return void
 */
function countNumbersInFile($filePath, &$count)
{
    $stringOfNumbers = file_get_contents($filePath);
    $numbers = preg_split('/[,| ]/', $stringOfNumbers);
    foreach ($numbers as $number) {
        $count += filter_var(trim($number), FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
    }
}
