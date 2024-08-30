<?php

namespace Rusdianto\Gevac\Helper;

use Rusdianto\Gevac\Service\SessionService;

class Helper
{
    public static function prepareViewData(SessionService $sessionService, array $additionalData = []): array
    {
        $activeUser = $sessionService->current();
        return array_merge($additionalData, [
            "activeUser" => [
                "name" => $activeUser->getNama(),
                "role" => $activeUser->getRoles()->value
            ]
        ]);
    }
}
