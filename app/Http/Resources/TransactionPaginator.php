<?php

namespace App\Http\Resources;

use Illuminate\Pagination\LengthAwarePaginator;

class TransactionPaginator extends LengthAwarePaginator
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'transactions' => $this->items->toResourceCollection(),
            'current_page' => $this->currentPage(),
            'from' => $this->firstItem(),
            'last_page' => $this->lastPage(),
            'per_page' => $this->perPage(),
            'to' => $this->lastItem(),
            'total' => $this->total(),
        ];
    }
}
