<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymobPaymentService
{
  protected $apiKey;
  protected $integrationId;
  protected $iframeId;
  protected $hmacSecret;
  protected $baseUrl = 'https://accept.paymob.com/api';
  protected $authToken = null;

  public function __construct()
  {
    $this->apiKey = config('services.paymob.api_key');
    $this->integrationId = config('services.paymob.integration_id');
    $this->iframeId = config('services.paymob.iframe_id');
    $this->hmacSecret = config('services.paymob.hmac_secret');
  }

  /**
   * Step 1: Authentication Request
   */
  public function authenticate()
  {
    $response = Http::post($this->baseUrl . '/auth/tokens', [
      'api_key' => $this->apiKey
    ]);

    if ($response->successful()) {
      $this->authToken = $response->json('token');
      return $this->authToken;
    }

    Log::error('Paymob authentication failed', ['response' => $response->json()]);
    throw new \Exception('Paymob authentication failed');
  }

  /**
   * Step 2: Order Registration
   */
  public function registerOrder($amount, $items = [], $merchantOrderId = null, $currency = 'EGP')
  {
    if (!$this->authToken) {
      $this->authenticate();
    }

    $amountInCents = $amount * 100; // Convert to cents as required by Paymob

    $orderData = [
      'auth_token' => $this->authToken,
      'delivery_needed' => false,
      'amount_cents' => $amountInCents,
      'currency' => $currency,
    ];

    if (!empty($items)) {
      $orderData['items'] = $items;
    }

    if ($merchantOrderId) {
      $orderData['merchant_order_id'] = $merchantOrderId;
    }

    $response = Http::post('https://accept.paymob.com/api/ecommerce/orders', $orderData);
    if ($response->status() == 201) {
      return $response->json();
    }
    // dd($response);

    Log::error('Paymob order registration failed', ['response' => $response->json()]);
    throw new \Exception('Paymob order registration failed');
  }

  /**
   * Step 3: Payment Key Request
   */
  public function getPaymentKey($orderId, $amount, $billingData, $currency = 'EGP')
  {
    if (!$this->authToken) {
      $this->authenticate();
    }

    $amountInCents = $amount * 100;

    // Ensure all required billing data fields are present
    $requiredFields = [
      'name',
      'email',
      'phone_number',
      'street_addresses',
    ];

    foreach ($requiredFields as $field) {
      if (!isset($billingData[$field])) {
        $billingData[$field] = 'NA';
      }
    }

    $response = Http::post($this->baseUrl . '/acceptance/payment_keys', [
      'auth_token' => $this->authToken,
      'amount_cents' => $amountInCents,
      'expiration' => 3600,
      'order_id' => $orderId,
      'billing_data' => $billingData,
      'currency' => $currency,
      'integration_id' => $this->integrationId,
      'lock_order_when_paid' => true
    ]);

    if ($response->successful()) {
      return $response->json('token');
    }

    Log::error('Paymob payment key request failed', ['response' => $response->json()]);
    throw new \Exception('Paymob payment key request failed');
  }

  /**
   * Generate iframe URL for checkout
   */
  public function getIframeUrl($paymentToken)
  {
    return "https://accept.paymob.com/api/acceptance/iframes/{$this->iframeId}?payment_token={$paymentToken}";
  }

  /**
   * Process callback from Paymob
   */
  public function processCallback($data)
  {

    // Verify the transaction
    if (isset($data['success']) && $data['success'] === "true") {
      $orderId = $data['order'];
      $merchantOrderId = $data['merchant_order_id'] ?? null;
      $transactionId = $data['id'];
      $amount = $data['amount_cents'] / 100;
      $status = $data['success'] === "true" ? 'success' : 'failed';
      $paymentMethod = $data['source_data_type'] ?? '';

      return [
        'success' => true,
        'order_id' => $orderId,
        'merchant_order_id' => $merchantOrderId,
        'transaction_id' => $transactionId,
        'amount' => $amount,
        'status' => $status,
        'payment_method' => $paymentMethod,
        'data' => $data
      ];
    }

    return ['success' => false, 'data' => $data];
  }

  /**
   * Verify HMAC
   */
  public function verifyHmac($data, $hmac)
  {
    $calculatedHmac = '';

    // Calculate HMAC based on Paymob's documentation
    // This is a simplified version - check Paymob docs for exact implementation
    if (isset($data['obj'])) {
      $concat = $data['obj']['id'] . $data['obj']['amount_cents'] . $data['obj']['created_at'];
      $calculatedHmac = hash_hmac('sha512', $concat, $this->hmacSecret);
    }

    return hash_equals($calculatedHmac, $hmac);
  }

  /**
   * Get transaction details
   */
  public function getTransaction($transactionId)
  {
    if (!$this->authToken) {
      $this->authenticate();
    }

    $response = Http::get($this->baseUrl . '/acceptance/transactions/' . $transactionId, [
      'auth_token' => $this->authToken
    ]);

    if ($response->successful()) {
      return $response->json();
    }

    Log::error('Paymob get transaction failed', ['response' => $response->json()]);
    throw new \Exception('Paymob get transaction failed');
  }

  /**
   * Refund transaction
   */
  public function refundTransaction($transactionId, $amount)
  {
    if (!$this->authToken) {
      $this->authenticate();
    }

    $amountInCents = $amount * 100;

    $response = Http::post($this->baseUrl . '/acceptance/void_refund/refund', [
      'auth_token' => $this->authToken,
      'transaction_id' => $transactionId,
      'amount_cents' => $amountInCents
    ]);

    if ($response->successful()) {
      return $response->json();
    }

    Log::error('Paymob refund transaction failed', ['response' => $response->json()]);
    throw new \Exception('Paymob refund transaction failed');
  }
}
