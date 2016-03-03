# Simple transfer.sh client

## Installation

    composer require Raz0rwire/transferh

## Code Example

    use CodeBridge\Transfer;

    $file_path = realpath('./whatever.ext');
    $transfer_client = new Transfer();

    $download_url = $transfer_client->send($file_path);

## More complex example (for self hosted installations)

    use CodeBridge\Transfer;

    $file_path = realpath('./whatever.ext');
    $transfer_client = new Transfer('http', 'yourdomain.com');

    $download_url = $transfer_client->send($file_path, 'somecustomname.ext');