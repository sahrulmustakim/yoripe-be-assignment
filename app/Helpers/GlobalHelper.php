<?php
    
/**
 * Default response application
 *
 * @param bool $status
 * @param int $code
 * @param string $message
 * @param null $data
 * @return \Illuminate\Http\JsonResponse
 */
function apiResponse(bool $status, int $code, string $message, $data = null, $other = [])
{
    return response()
        ->json(
            collect(
                [
                    'status' => $status,
                    'code' => $code,
                    'text' => config('code.'. $code),
                    'message' => $message,
                    'data' => $data
                ]
            )->merge($other), 
            $code
        );
}

/**
 * Response Success
 * 
 * @param String $message Message
 * @param String $data    Data
 * 
 * @return json
 */

function apiResponseSuccess($data, $message = 'Success', $other = [])
{
    return apiResponse(true, 200, $message, $data, $other);
}

/**
 * Response Failed
 * 
 * @param String $message Message
 * @param String $data    Data
 * 
 * @return json
 */

function apiResponseFailed($message, $data = null)
{
    return apiResponse(false, 500, $message, $data);
}