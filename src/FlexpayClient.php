<?php
namespace EvansWanguba\Flexpay;

use GuzzleHttp\Client;
use EvansWanguba\Flexpay\Contracts\FlexpayClientContract;
use GuzzleHttp\Exception\GuzzleException;

class FlexpayClient implements FlexpayClientContract
{
    protected array $config;
    protected Client $http;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->http = new Client([
            'base_uri' => rtrim($config['base_url'], '/'),
            'timeout' => $config['timeout'] ?? 10,
        ]);
    }

    protected function postForm(string $path, array $form): array
    {
        // Always include auth
        $form = array_merge($form, [
            'apiKey' => $this->config['api_key'] ?? '',
            'apiSecret' => $this->config['api_secret'] ?? '',
        ]);

        try {
            $res = $this->http->post($path, [
                'form_params' => $form,
                'http_errors' => false,
            ]);

            $body = (string) $res->getBody();
            $json = json_decode($body, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $json;
            }

            return ['status' => $res->getStatusCode(), 'raw' => $body];
        } catch (GuzzleException $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    /**
     * Create a booking (online). See docs: /book/flexpay/endpoint
     * Required: productName, productPrice, phoneNumber, productDeposit, bookingDays, paymentType
     */
    public function book(array $data): array
    {
        $path = $this->config['endpoints']['book'];
        return $this->postForm($path, $data);
    }

    /**
     * POS validation (offline/online)
     * Required: receiptNumber, checkoutAmount, cashierID
     */
    public function validatePos(array $data): array
    {
        $path = $this->config['endpoints']['checkout_validation'];
        return $this->postForm($path, $data);
    }

    /**
     * Online checkout step 1 (request OTP)
     * Required: receiptNumber, phoneNumber, checkoutAmount
     */
    public function validateOnline(array $data): array
    {
        $path = $this->config['endpoints']['checkout_validation_online'];
        return $this->postForm($path, $data);
    }

    /**
     * Online checkout step 2 (confirm OTP)
     * Required: otp, phoneNumber
     */
    public function confirmOtp(array $data): array
    {
        $path = $this->config['endpoints']['checkout_validate_otp'];
        return $this->postForm($path, $data);
    }

    /**
     * IPN (notify Flexpay of merchant slip/invoice)
     * Required: receiptNumber, slipNumber
     */
    public function ipn(array $data): array
    {
        $path = $this->config['endpoints']['ipn'];
        return $this->postForm($path, $data);
    }
}
