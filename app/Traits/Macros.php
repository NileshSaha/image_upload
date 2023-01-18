<?php

namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;


trait Macros
{
    /**
     * @param string $message
     * @param int $code
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respond(string $message, int $code, array $data = [])
    {
        $payload = [];

        $payload['message'] = $message;
        if (!empty($data)) {
            $payload['data'] = $data;
        }
        return response()->json($payload, $code);
    }

    /**
     * Generates the pagination meta from the paginator object.
     *
     * @param LengthAwarePaginator $objects
     * @return array
     */
    protected function generateMeta(LengthAwarePaginator $objects): array
    {
        return [
            'total' => $objects->total(),
            'limit' => (int) $objects->perPage(),
            'has_next' => $objects->hasMorePages(),
            'current_page' => $objects->currentPage(),
            'next_page_url' => $objects->nextPageUrl(),
            'previous_page_url' => $objects->previousPageUrl()
        ];
    }
}
