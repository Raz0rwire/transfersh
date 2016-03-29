<?php

namespace CodeBridge;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use splitbrain\PHPArchive\Zip;


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
     * @param $file
     * @param string $file_name
     * @return string
     * @throws \splitbrain\PHPArchive\ArchiveIOException
     */
    public function send($file, $file_name = '')
    {
        if (is_array($file)) {
            $zip = new Zip();
            $zip->create();

            foreach ($file as $f) {
                $zip->addFile($f);
            }

            if (!$file_name) {
                $file_name = 'Archive.zip';
            } else {
                $file_name = $file_name . '.zip';
            }
            $contents = $zip->getArchive();
        } else if (is_file($file)) {
            if (!$file_name) {
                $file_name = basename($file);
            }

            $contents = file_get_contents($file);
        } else {
            throw new TransferException('File not found');
        }

        $response = $this->client->put('/' . $file_name, [
            'body' => $contents
        ]);

        return trim($response->getBody()->getContents());
    }

}