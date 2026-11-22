<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Midtrans_snap
{
    private $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->config->load('midtrans', TRUE);
    }
    public function configured()
    {
        return $this->CI->config->item('midtrans_server_key', 'midtrans') !== '';
    }
    public function create($orderId, $grossAmount, $customer)
    {
        if (!$this->configured()) return array('simulated'=>TRUE, 'payment_url'=>NULL, 'token'=>NULL);
        $production = $this->CI->config->item('midtrans_is_production', 'midtrans');
        $url = $production ? 'https://app.midtrans.com/snap/v1/transactions' : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
        $payload = array('transaction_details'=>array('order_id'=>$orderId,'gross_amount'=>(int)$grossAmount), 'customer_details'=>$customer);
        $ch = curl_init($url);
        curl_setopt_array($ch, array(CURLOPT_POST=>TRUE, CURLOPT_POSTFIELDS=>json_encode($payload), CURLOPT_RETURNTRANSFER=>TRUE, CURLOPT_HTTPHEADER=>array('Content-Type: application/json','Accept: application/json'), CURLOPT_USERPWD=>$this->CI->config->item('midtrans_server_key','midtrans').':', CURLOPT_TIMEOUT=>15));
        $body = curl_exec($ch); $status = curl_getinfo($ch, CURLINFO_HTTP_CODE); $error = curl_error($ch); curl_close($ch);
        if ($body === FALSE || $status < 200 || $status >= 300) throw new RuntimeException('Midtrans Snap request failed (HTTP '.$status.'): '.$error);
        $result = json_decode($body, TRUE);
        if (empty($result['token'])) throw new RuntimeException('Midtrans response did not include a Snap token.');
        return array('simulated'=>FALSE,'payment_url'=>$result['redirect_url'] ?? NULL,'token'=>$result['token']);
    }
}
