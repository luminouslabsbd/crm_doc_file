<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Hyper_payment_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get article by id
     * @param  string $id   article ID
     * @param  string $slug if search by slug
     * @return mixed       if ID or slug passed return object else array
     */
    
    public function updateInvoiceData($invoicePaymeny,$invoiceId,$external_id)
    {   
        // 1 = unpaid , 3 = partial , 4 = overdue
        $desired_statuses = array(1, 4);
        
        $this->load->database();
        $this->db->select('id');
        $this->db->where('number',$invoiceId);
        $this->db->where_in('status',$desired_statuses);
        $this->db->where('id',$invoiceId);
        $getId = $this->db->get(db_prefix() . 'invoices')->row();
        
        if ($getId) {
            // Update Invoice Payment Staus
            $this->db->where('id', $getId->id);
            $this->db->update(db_prefix() . 'invoices', [
                'status' => 2,
            ]);
            // Insert Invoice Payment Records
            $this->db->insert( db_prefix() . 'invoicepaymentrecords', $invoicePaymeny);
            // Send Curl Request To Lago 
            $this->sendRequestToLagoBillingServer($invoicePaymeny,$invoiceId,$external_id);
            // Check for Success
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }else{
            
        }
        
    }
    
    public function getGetwayData(){
        
        $result['paymentmethod_hyperswitch_active'] = get_option('paymentmethod_hyperswitch_active');
        $result['paymentmethod_hyperswitch_label'] = get_option('paymentmethod_hyperswitch_label');
        $result['paymentmethod_hyperswitch_api_secret_key'] = get_option('paymentmethod_hyperswitch_api_secret_key');
        $result['paymentmethod_hyperswitch_api_publishable_key'] = get_option('paymentmethod_hyperswitch_api_publishable_key');
        $result['paymentmethod_hyperswitch_currencies'] = get_option('paymentmethod_hyperswitch_currencies');
        $result['paymentmethod_hyperswitch_test_mode_enabled'] = get_option('paymentmethod_hyperswitch_test_mode_enabled');
        $result['paymentmethod_hyperswitch_initialized'] = get_option('paymentmethod_hyperswitch_initialized');
        $result['paymentmethod_hyperswitch_default_selected'] = get_option('paymentmethod_hyperswitch_default_selected');
        
        return $result;
        
        
        
    }
    
    public function is_invoice_check($hashValue){
        
        $desired_statuses = array(1, 3, 4);
        
        $this->load->database();
        $this->db->select('*');
        $this->db->where_in('status',$desired_statuses);
        $getData = $this->db->get(db_prefix() . 'invoices')->row();
        
        if($getData != null){
          return $getData;  
        }else{
            return null;
        }
        
        $this->load->database();
        $this->db->select('id ,total ,clientid');
        $this->db->where('hash',$hashValue);
        $this->db->where_in('status',$desired_statuses);
        $getData = $this->db->get(db_prefix() . 'invoices')->row();
        
        if($getData != null){
          return $getData;  
        }else{
            return null;
        }
    }
    
    public function sendRequestToLagoBillingServer($invoicePaymeny,$invoiceId,$external_id){
        
        $this->load->database();
        $this->db->select('id,lago_id,lago_invoice_id');
        $this->db->where('client_id',$external_id);
        $this->db->where('invoice_id',$invoiceId);
        $getData = $this->db->get(db_prefix() . 'lago_invoice')->row();
        if($getData != null){
          $lago_id = $getData->lago_id;
          $this->sendCurlLago($invoicePaymeny,$lago_id);
          return true;
          
        }else{
            return false;
        }
        
        
    }
    
    public function sendCurlLago($invoicePaymeny,$lago_id){
        
        $LAGO_URL = 'https://billingapi.keoscx.com';
        $API_KEY = 'd7fadbee-9b56-4076-bee9-4104612ef09b';
        $url = $LAGO_URL . "/api/v1/invoices/{$lago_id}";

        $headers = array(
            'Authorization: Bearer ' . $API_KEY,
            'Content-Type: application/json'
        );
        
        $data = array(
            'invoice' => array(
                'payment_status' => 'succeeded',
                'metadata' => array(
                    array(
                        'id' => $invoicePaymeny['invoiceid'],
                        'key' => 'digital_ref_id',
                        'value' => $invoicePaymeny['transactionid']
                    )
                )
            )
        );
        // Convert data to JSON format
        $json_data = json_encode($data);
        $ch = curl_init($url);
        // curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Use PUT method
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        
        // Handle the response as needed
        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        }else{
           // Check HTTP response code
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($http_code !== 200) {
                echo 'HTTP Error: ' . $http_code;
                // Handle specific HTTP error codes if needed
            } else {
                // Handle the response as needed
                echo $response;
            }
        }
        return $response;

    }

    

   
}
