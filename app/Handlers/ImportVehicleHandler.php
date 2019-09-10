<?php


namespace App\Handlers;


use App\Exceptions\ImportException;
use App\Interactions\CreateVehicle;
use App\Imports\VehicleImport;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

class ImportVehicleHandler
{
    protected $content;
    public $filename;
    public $status = [
        'filename' => '',
        'inserted' => 0,
        'updated' => 0,
        'failed' => 0,
        'errors' => [],
        'is_completed' => false,
    ];
    /**
     * @var VehicleImport
     */
    private $importService;

    public function __construct(VehicleImport $importService)
    {
        $this->importService = $importService;
    }

    public function load(string $filename)
    {
        if (file_exists($filename)) {
            try {
                $reader = IOFactory::createReaderForFile($filename);
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($filename);
                $this->setFilename($filename);
            } catch (Exception $e) {
                throw new InvalidContentException('Unable to open file.' . $e->getMessage());
            }

        } else {
            throw new InvalidContentException('Unable to open file.');
        }
        return $this->resolveData($spreadsheet);
    }

    public function run()
    {
        $this->status['filename'] = $this->getFilename();
        $content = $this->getContent();
        DB::beginTransaction();
        try {
            $this->importFromArray($content);
            $this->status['is_completed'] = ($this->status['updated'] + $this->status['inserted']);
            if ($this->status['is_completed'] == 0) {
                DB::rollBack();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new ImportException('Error:' . $e->getMessage());
        }
        return $this->status;
    }

    public function resolveData($spreadsheet)
    {
        if (!$spreadsheet) {
            throw new InvalidContentException('Unable to load csv.');
        }
        $output = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);;
        $this->setContent($output);
        return $this;
    }

    public function getFilename()
    {
        return basename($this->filename);
    }

    public function setFilename($filename): void
    {
        $this->filename = $filename;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function importFromArray($data)
    {
        $counter = 0;

        $collection = $this->removeHeader($data);
        $collection->each(function ($row) use (&$counter) {
            $counter++;
            $outcome = $this->importService->import($row);

            if ($outcome->valid) {
                if ($outcome->result->wasRecentlyCreated) {
                    $this->status['inserted']++;
                } else {
                    $this->status['updated']++;
                }
                return [
                    'success' => true,
                    'store' => $outcome->result,
                ];
            }
            $this->status['failed']++;
            $key = !empty($row['number']) ? $row['number'] : 0;
            $this->status['errors'][$key] = $outcome->errors->toArray();
            return [
                'success' => false,
                'errors' => $this->status['errors'][$key],
            ];
        });

        return $this->status;
    }

    /**
     * @param $data
     * @return \Illuminate\Support\Collection
     */
    private function removeHeader($data): \Illuminate\Support\Collection
    {
        $collection = collect($data);
        $collection->shift();
        return $collection;
    }
}