<?php

namespace App\Imports;

use App\Notifications\ProductsImport as ProductsImportNotification;
use App\User;
use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;

class ProductsImport implements ToModel, WithChunkReading, ShouldQueue, WithEvents
{

    use Importable;

    public function __construct(User $importedBy)
    {
        $this->importedBy = $importedBy;
    }
    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterImport::class => function(AfterImport $event) {
                $this->importedBy->notify(new ProductsImportNotification);
            },			                        
        ];
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {   
        return new Product([
            'name' => $row[0],
            'description' => $row[1],
            'category' => $row[2],
            'price' => $row[3]
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }
}
