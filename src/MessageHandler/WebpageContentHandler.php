<?php

namespace App\MessageHandler;

use App\Message\WebpageContent;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class WebpageContentHandler implements MessageHandlerInterface
{
    public function __invoke(WebpageContent $message)
    {
        file_put_contents('/tmp/xavi.log', 'good', FILE_APPEND);
    }
}
