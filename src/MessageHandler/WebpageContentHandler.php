<?php

namespace App\MessageHandler;

use App\Message\WebpageContent;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class WebpageContentHandler implements MessageHandlerInterface
{

    /** @var LoggerInterface */
    protected LoggerInterface $logger;

    /** @var ParameterBagInterface */
    protected ParameterBagInterface $parameterBag;

    /**
     * @param  LoggerInterface  $logger
     */
    public function __construct(
        LoggerInterface $logger,
        ParameterBagInterface $parameterBag
    ) {
        $this->logger       = $logger;
        $this->parameterBag = $parameterBag;
    }

    /**
     * @throws \Exception
     */
    public function __invoke(WebpageContent $message)
    {
        $xml = simplexml_load_string('<div>'.$message->getContent().'</div>');

        if (!is_dir($this->parameterBag->get('articles_directory'))) {
            mkdir($this->parameterBag->get('articles_directory'), 775, true);
        }

        foreach ($xml as $div) {
            $title    = $div->a[0]->h2;
            $img      = $div->a[1]->div->img['src'];
            $pathInfo = pathinfo($img);
            file_put_contents($this->parameterBag->get('articles_directory').'/'
                .$pathInfo['basename'], file_get_contents($img));
            $shortDescription = $div->p;
            $this->logger->info($title);
            $this->logger->info($shortDescription);
            $this->logger->info($img);
        }
    }

}
