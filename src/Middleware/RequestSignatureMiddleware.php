<?php declare(strict_types = 1);

namespace Link0\Bunq\Middleware;

use GuzzleHttp\Psr7\Request;
use Link0\Bunq\Domain\Keypair\PrivateKey;
use Psr\Http\Message\RequestInterface;

final class RequestSignatureMiddleware
{
    const SIGNATURE_ALGORITHM = OPENSSL_ALGO_SHA256;

    private const HEADER_PREFIX = 'X-Bunq-';

    /**
     * @var PrivateKey
     */
    private $privateKey;

    public function __construct(PrivateKey $privateKey)
    {
        $this->privateKey = $privateKey;
    }

    /**
     * @throws \Exception
     */
    public function sign(string $data): string
    {
        if (openssl_sign($data, $signature, (string) $this->privateKey, static::SIGNATURE_ALGORITHM) !== true) {
            throw new \Exception("Could not sign request: " . openssl_error_string());
        }
        return $signature;
    }
    /**
     * @param array            $options
     */
    public function __invoke(RequestInterface $request, array $options = []) : Request
    {
        $headers = $request->getHeaders();
        ksort($headers);

        $signatureData = (string) $request->getBody();
        $signature = $this->sign($signatureData);

        $headers['X-Bunq-Client-Signature'] = base64_encode($signature);

        $signedRequest = new Request(
            $request->getMethod(),
            $request->getUri(),
            $headers,
            $request->getBody()
        );

        return $signedRequest;
    }
}
