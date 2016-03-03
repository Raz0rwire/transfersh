# Simple transfer.sh client

## Installation

    composer require codebridge/transfersh

## Code Example

    use CodeBridge\Transfer;

    $transfer_client = new Transfer();

    $file_path = realpath('./whatever.ext');
    $download_url = $transfer_client->send($file_path);

## More complex example (for self hosted installations)

    use CodeBridge\Transfer;

    $transfer_client = new Transfer('http', 'yourdomain.com');

    $file_path = realpath('./whatever.ext');
    $download_url = $transfer_client->send($file_path, 'somecustomname.ext');