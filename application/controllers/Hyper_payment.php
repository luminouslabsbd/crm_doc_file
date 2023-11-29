<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Hyper_payment extends ClientsController
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('hyper_payment_model');

    }

    public function index()
    {
        $this->load->library('input');
        
        $this->load->library('session');
        $hashValue = $this->input->get('hash');
        
        $isCheckData = $this->hyper_payment_model->is_invoice_check($hashValue);
        $getway = $this->hyper_payment_model->getGetwayData();
        
        if($isCheckData != null && $getway['paymentmethod_hyperswitch_active']){
        
            $paymentData = [];
            $paymentData['amount'] = $isCheckData->total;
            $paymentData['invoice_id'] = $isCheckData->id;
            $paymentData['external_id']= $isCheckData->clientid;
            $paymentData['currency'] =  "USD";
            $paymentData['paymentmethod_hyperswitch_api_secret_key'] = $this->encryption->decrypt($getway['paymentmethod_hyperswitch_api_secret_key']);
            $paymentData['paymentmethod_hyperswitch_api_publishable_key'] = $getway['paymentmethod_hyperswitch_api_publishable_key'];
            $paymentData['test_mode'] = $getway['paymentmethod_hyperswitch_test_mode_enabled'] ;
            
            $this->session->set_userdata('invoice_payment_data', $paymentData);
            
            $data['title']                 = _l('Payment Getway Page');
            $data['invoice_id'] = $isCheckData->id ;
            $data['hyperswitch_api_secret_key'] = $this->encryption->decrypt($getway['paymentmethod_hyperswitch_api_secret_key'] );
            
            $this->data($data);
            $this->view('hyper_payment');
            $this->layout();
        
        }else{
            redirect(site_url('404_override'));
        }
        
        
    }
    
    public function api_request_to_getway(){
        
        $this->load->library('session');
        
        $invoice_payment_data = $this->session->userdata('invoice_payment_data');
        $invoiceId = $invoice_payment_data['invoice_id'];
        $external_id = $invoice_payment_data['external_id'];
        $amount = $invoice_payment_data['amount'] ;
        $api_publishable_key = $invoice_payment_data['paymentmethod_hyperswitch_api_publishable_key'] ;
        
        $hyperswitch_secret_key = $api_publishable_key ;
        
        $jsonStr = file_get_contents('php://input');
        $jsonObj = json_decode($jsonStr);
        
        $hyperswitch_secret_key = $api_publishable_key ;
        
        $jsonStr = file_get_contents('php://input');
        $jsonObj = json_decode($jsonStr);
        
        if($invoice_payment_data['test_mode'] == 1){
            $HYPER_SWITCH_API_BASE_URL =  "https://sandbox.hyperswitch.io/payments";
        }else{
            // 0 - Live Url 
            $HYPER_SWITCH_API_BASE_URL =  "https://api.hyperswitch.io/payments";
        }
        
        try {
            $payload = json_encode(array(
                "amount" => $this->calculateOrderAmount($amount),
                "currency" => "USD",
                "customer_id" => $external_id,
            ));
        
            $ch = curl_init($HYPER_SWITCH_API_BASE_URL);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Accept: application/json',
                'api-key: ' . $hyperswitch_secret_key
            ));
            $responseFromAPI = curl_exec($ch);
            if ($responseFromAPI === false) {
                 $output = json_encode(array("error" => curl_error($ch)), 403);
            }
            
            curl_close($ch);
            
            $decoded_response = json_decode($responseFromAPI, true);

            if(isset($decoded_response['error'])){
                $output=array("client_secret" => false);
            }else{
                $output=array("client_secret" => $decoded_response['client_secret']);
            }
            echo json_encode($output);
        
        } catch (Exception $e) {
            echo json_encode(array("error" => $e->getMessage()), 403);
        }
    }
    
    public function calculateOrderAmount($items): int {
        return $items;
    }
    
    public function update_invoice_status(){
        
        
        
        $this->load->library('session');
        if($this->session->has_userdata('invoice_payment_data')) {
            
            $invoice_payment_data = $this->session->userdata('invoice_payment_data');
            $invoiceId = $invoice_payment_data['invoice_id'];
            $external_id = $invoice_payment_data['external_id'];
            $api_publishable_key = $invoice_payment_data['paymentmethod_hyperswitch_api_publishable_key'] ;
        }
        
        $hyperswitch_secret_key = $api_publishable_key;
        
        if($invoice_payment_data['test_mode'] == 1){
            $url = "https://sandbox.hyperswitch.io/payments/" ;
        }else{
            $url = "https://api.hyperswitch.io/payments/";
        }
        
        die("fff");
        
        $payment_id = $this->input->post('payment_id');
        $status = $this->input->post('status');
        $merchant_id = $this->input->post('merchant_id');
        $client_secret = $this->input->post('client_secret');

        $payload = json_encode(array(
            "merchant_id" => $merchant_id,
            "force_sync" => true,
            "client_secret" => $client_secret,
            "expand_attempts" => true,
        ));

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url.$payment_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'api-key: ' . $hyperswitch_secret_key,
        ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        $data=json_decode($response);
            
		if ($err) {
			 $this->session->unset_userdata('invoice_payment_data');
             redirect(site_url('payment-failed'));
		} else {
			$data=json_decode($response);
            // If Payment Is Succeeded
			if($data->status == 'succeeded' && $data->payment_id != null){
				$ref_id= $data->payment_id ;
				$amount = $data->amount;
				
				$invoicePaymeny = array(
                   'invoiceid' => $invoiceId,
                   'amount' => $amount,
                   'paymentmode' => 1,
                   'paymentmethod' => 'hyperswitch',
                   'date' => date('Y-m-d'),
                   'note' => "payment done by hyperswitch",
                   'daterecorded' => date('Y-m-d H:i:s'),
                   'transactionid' => $data->payment_id,
                );
                $isInserted = $this->hyper_payment_model->updateInvoiceData($invoicePaymeny,$invoiceId,$external_id);
                
				$this->session->unset_userdata('invoice_payment_data');
                redirect(site_url('payment-successful'));
			}
            // If Payment Is Failed 
			if($data->status == 'failed'){
				$this->session->unset_userdata('invoice_payment_data');
                redirect(site_url('payment-failed'));
			}
		}

    }
  
    
    public function payment_complete(){
        
        $this->load->library('input');
        $this->load->library('session');
        
        $status = $this->input->get('status');
       
        $payment_intent_client_secret = $this->input->get('payment_intent_client_secret');
        
        // For Succeeded
        if ($this->session->has_userdata('invoice_payment_data')) {
            
            $invoice_payment_data = $this->session->userdata('invoice_payment_data');
            
            $invoiceId = $invoice_payment_data['invoice_id'];
            $external_id = $invoice_payment_data['external_id'];
           
            if($status == 'succeeded' && $payment_intent_client_secret  != null){
                $amount = $this->input->get('amount');
                $invoicePaymeny = array(
                   'invoiceid' => $invoiceId,
                   'amount' => $amount,
                   'paymentmode' => 1,
                   'paymentmethod' => 'hyperswitch',
                   'date' => date('Y-m-d'),
                   'note' => "payment done by hyperswitch",
                   'daterecorded' => date('Y-m-d H:i:s'),
                   'transactionid' => $payment_intent_client_secret,
                );
                $isInserted = $this->hyper_payment_model->updateInvoiceData($invoicePaymeny,$invoiceId,$external_id);

                $this->session->unset_userdata('invoice_payment_data');
                redirect(site_url('payment-successful'));

            }
            
        }
        
        // For Failed
        if ($this->session->has_userdata('invoice_payment_data')) {
            
            $invoice_payment_data = $this->session->userdata('invoice_payment_data');
            
            $invoiceId = $invoice_payment_data['invoice_id'];
            $external_id = $invoice_payment_data['external_id'];
           
            if($status == 'failed'){
                $this->session->unset_userdata('invoice_payment_data');
                redirect(site_url('payment-failed'));
            }
        }
        
    }
    
    public function payment_failed(){
        
        $this->view('hyper_payment_failed');
        $this->layout();
        
    }
    
    public function payment_successful(){
        
        $this->view('hyper_payment_succeeded');
        $this->layout();
        
    }

    
    

    
}
