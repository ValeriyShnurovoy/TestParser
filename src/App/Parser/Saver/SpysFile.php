<?php

namespace App\Parser\Saver;

class SpysFile implements Saver
{
    public function saveData(array $data)
    {
        $filename = __DIR__ . "/export.csv";
        $delimiter=";";
        $title = [];

        $isExists = file_exists($filename);
        if (!$isExists) {
            $title = array_keys($data[0]);
        }
        $f = fopen($filename, 'a+');

        if (!empty($title)) {
            fputcsv($f, $title, $delimiter);
        }

        foreach ($data as $line) {
            fputcsv($f, $line, $delimiter);
        }

        fclose($f);
    }
}