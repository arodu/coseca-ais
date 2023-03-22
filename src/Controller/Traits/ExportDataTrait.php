<?php

declare(strict_types=1);

namespace App\Controller\Traits;

use Cake\Utility\Hash;

trait ExportDataTrait
{
    public function exportCsv(array $data, array $fields, array $options = [])
    {
        $results = array_map(function ($row) use ($fields) {
            $result = [];
            foreach ($fields as $key => $field) {
                if (!is_numeric($key)) {
                    $field = $key;
                }

                $result[] = Hash::get($row, $field);
            }
            return $result;
        }, $data);

        $results = array_merge([$fields], $results);

        return $this->response
                    ->withType('csv')
                    ->withDownload($options['filename'] ?? 'export.csv')
                    ->withStringBody($this->arrayToCsv($results));
    }

    public function arrayToCsv(array $data)
    {
        $output = fopen('php://memory', 'w');
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        //fclose($output);
        rewind($output);
        return stream_get_contents($output);
    }
}
