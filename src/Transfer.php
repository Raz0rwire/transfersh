<?php

namespace CodeBridge;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;

class Transfer
{

    /**
     * @var string $transfer_protocol
     */
    private $transfer_protocol = 'https';

    /**
     * @var string $transfer_uri
     */
    private $transfer_uri = 'transfer.sh';

    /**
     * Transfer constructor.
     * @param null $protocol
     * @param null $uri
     */
    public function __construct($protocol = null, $uri = null)
    {

        $protocol = $protocol ? $protocol : $this->transfer_protocol;
        $uri = $uri ? $uri : $this->transfer_uri;

        $this->client = new Client(
            [
                'base_uri' => $protocol . '://' . $uri
            ]
        );
    }

    /**
     * @param string $path
     * @param string $file_name
     * @return string
     */
    public function send($path, $file_name = '')
    {
        if (!is_file($path)) {
            throw new TransferException('File not found');
        }

        if (!$file_name) {
            $file_name = basename($path);
        }

        $response =  $this->client->put('/' . $file_name, [
            'body' => file_get_contents($path)
        ]);

        return trim($response->getBody()->getContents());
    }

}