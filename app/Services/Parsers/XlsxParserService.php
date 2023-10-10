<?php

declare(strict_types=1);

namespace App\Services\Parsers;

use App\Exceptions\FileHeaderMissingException;
use App\Exceptions\UnableToReadFileException;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class XlsxParserService implements ParserServiceInterface
{
    private array $columnMappings = [
        'A' => 'id',
        'B' => 'name',
        'C' => 'date',
    ];
    private Worksheet $sheet;

    /**
     * @throws UnableToReadFileException
     * @throws FileHeaderMissingException
     */
    public function load(string $absPath): void
    {
        $xlsx = new Xlsx();
        if (! $xlsx->canRead($absPath)) {
            throw new UnableToReadFileException();
        }

        $spreadSheet = $xlsx->load($absPath);
        $this->sheet = $spreadSheet->getActiveSheet();
        $iterator = $this->sheet->getColumnIterator('A', 'C');

        $headers = $this->columnMappings;

        foreach ($iterator as $cal) {
            foreach ($cal->getCellIterator(1,1) as $cell) {
                if (! in_array($cell->getValue(), $headers, true)) {
                    throw new FileHeaderMissingException($cell->getValue());
                }
            }
        }
    }

    public function getRowCount(): int
    {
        return $this->sheet->getHighestDataRow('A');
    }

    public function iterate(callable $callable): void
    {
        $rowCount = $this->getRowCount();

        $iterate = ceil($rowCount / 1000);

        $start = 2;
        for ($i = 1; $i <= $iterate; $i++) {
            $end = $i * 1000 + 1;
            if ($end >= $rowCount) {
                $end = $rowCount;
            }
            $data = [];
            $iterator = $this->sheet->getRowIterator($start, $end);

            foreach ($iterator as $row) {
                $arr = [];
                foreach ($row->getCellIterator() as $cell) {
                    $key = $this->columnMappings[$cell->getColumn()];

                    $arr[$key] = $cell->getFormattedValue();
                }
                $data[] = $arr;
            }

            $callable($data);

            $start = $end + 1;
        }
    }
}
