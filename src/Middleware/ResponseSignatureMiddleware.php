<?php declare(strict_types = 1);

namespace Link0\Bunq\Middleware;

use Link0\Bunq\Domain\Keypair\PublicKey;
use Psr\Http\Message\ResponseInterface;

final class ResponseSignatureMiddleware
{
    const SIGNATURE_ALGORITHM = OPENSSL_ALGO_SHA256;

    private const HEADER_PREFIX = 'X-Bunq-';

    /**
     * @var PublicKey
     */
    private $publicKey;

    public function __construct(PublicKey $serverPublicKey)
    {
        $this->publicKey = $serverPublicKey;
    }

    /**
     * @throws \Exception
     */
    public function __invoke(ResponseInterface $response) : ResponseInterface
    {
        $header = $response->getHeader('X-Bunq-Server-Signature');

        if (isset($header[0])) {
            $serverSignature = $header[0];

            $signatureData = $response->getStatusCode();

            $headers = $response->getHeaders();
            ksort($headers);

            foreach ($headers as $header => $values) {
                // Skip the server signature itself
                if ($header === 'X-Bunq-Server-Signature') {
                    continue;
                }

                // Skip all headers that are not X-Bunq-
                if (strpos((string)$header, self::HEADER_PREFIX) !== 0) {
                    continue;
                }

                // Add all header data to verify signature
                foreach ($values as $value) {
                    $signatureData .= PHP_EOL . $header . ': ' . $value;
                }
            }

            $signatureData .= "\n\n";
            $signatureData .= (string)$response->getBody();

            $rawSignature = base64_decode($serverSignature);
            if (!\is_string($rawSignature)) {
                throw new \Exception('Failed base64 decoding server signature');
            }

            $verify = openssl_verify($signatureData, $rawSignature, (string)$this->publicKey, self::SIGNATURE_ALGORITHM);
            if ($verify !== 1) {
                throw new \Exception('Server signature does not match response');
            }
        }

        return $response;
    }
}
