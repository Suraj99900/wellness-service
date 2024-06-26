<?php

namespace App\Http\Middleware;

use App\Service\Client;
use Closure;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Log;


class EnsureTokenIsValid
{
    public function getClientIDFromHeader($request)
    {
        $sAuthorization = $request->header('Authorization');
        if (!$sAuthorization) {
            abort(401, 'Not able to find authorization header');
        }
        $aAuthorization = \explode('.', $sAuthorization);
        if (\count($aAuthorization) != 3) {
            throw new \Exception('Wrong number of segments');
        }

        $oHeader = json_decode(JWT::urlsafeB64Decode($aAuthorization[1]));
        return $oHeader->client_id ?? null;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $sClientID = $this->getClientIDFromHeader($request);
        $sAuthorization = $request->header('Authorization');

        if (!$sAuthorization) {
            abort(401, 'Not able to find authorization header');
        }

        if (!$sClientID) {
            abort(401, 'No client ID mentioned');
        }

        $oClient = (new Client)->getClientByClientID($sClientID);

        if (!$oClient) {
            abort(401, 'Not able to find client with Client ID ' . $sClientID);
        }
        Log::info('Client ID from header: ' . $sClientID);
        // JWT::decode(trim(substr($sAuthorization, 7)), $oClient->client_secret);

        $aAuthorization = \explode('.', $sAuthorization);
        $oHeader = json_decode(JWT::urlsafeB64Decode($aAuthorization[1]));

        // defining client id and clinic id and user id in confige
        config(['wellness-service.client_id' => $oClient->id]);
        // config(['wellness-service.user_id' => $oHeader->user_id]);
        // config(['wellness-service.user_name' => $oHeader->user_type]);
        
        return $next($request);
    }
}
