<?php declare(strict_types = 1);

namespace Link0\Bunq\Middleware;

use Link0\Bunq\Domain\Keypair\PublicKey;
use Psr\Http\Message\ResponseInterface;

final class ResponseSignatureMiddleware
{
    const SIGNATURE_ALGORITHM = OPENSSL_ALGO_SHA256;

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
            $rawSignature = base64_decode($serverSignature);
            if (!\is_string($rawSignature)) {
                throw new \Exception('Failed base64 decoding server signature');
            }
            $signatureData = (string)$response->getBody();
            $verify = openssl_verify($signatureData, $rawSignature, (string)$this->publicKey, self::SIGNATURE_ALGORITHM);
            if ($verify !== 1) {
                throw new \Exception('Server signature does not match response');
            }
        }

        return $response;
    }
}
