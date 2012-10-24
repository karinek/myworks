<?php
class M_options extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public static function getRegisteredYears(){
        $array = array(''=>'--- Please select ---');
        for($i=2012; $i>=1800; $i--){
            $array[$i] = $i;
        }
        return $array;
    }
    
    public static function getNoEmployee($key = 0){
        $array = array(
           '--- Please select ---',
           'Fewer than 5 People',
           '5 - 10 People',
           '11 - 50 People',
           '51 - 100 People',
           '101 - 200 People',
           '201 - 300 People',
           '301 - 500 People',
           '501 - 1000 People',
           'Above 1000 People'
        );
        if($key) return $array[$key];	
        return $array;				
    }
    
    public static function getOwnerShipDetails($key = 0){
        $array = array(
           '--- Please select ---',
           'Corporation/Limited Liability Company',
	   'Partnership',
           'LLC (Ltd Liability Corp)',
           'Individual (Sole proprietorship)',
           'Professional Association',
           'Others'
        );
        if($key) return $array[$key];	
        return $array;
    }
    
    public static function getRegisteredCapital($key = 0){
        $array = array(
            '--- Please select ---',
            'Below US$100 Thousand',
            'US$101 Thousand - US$500 Thousand',
            'US$501 Thousand - US$1 Million',
            'US$1 Million - US$2.5 Million',
            'US$2.5 Million - US$5 Million',
            'US$5 Million - US$10 Million',
            'US$10 Million - US$50 Million',
            'US$50 Million - US$100 Million',
            'Above US$100 Million'
        );
        if($key) return $array[$key];	
        return $array;
    }
    
    public static function getAnnualSaleDetails($key = 0){
        $array = array(
            '--- Please select ---',
            'Below US$1 Million',
            'US$1 Million - US$2.5 Million',
            'US$2.5 Million - US$5 Million',
            'US$5 Million - US$10 Million',
            'US$10 Million - US$50 Million',
            'US$50 Million - US$100 Million',
            'Above US$100 Million'
        );
        if($key) return $array[$key];
        return $array;
    }
    
    public static function getExportPercentages($key = 0){
        $array = array(
            '--- Please select ---',
            '1% - 10%',
            '11% - 20%',
            '21% - 30%',
            '31% - 40%',
            '41% - 50%',
            '51% - 60%',
            '61% - 70%',
            '71% - 80%',
            '81% - 90%',
            '91% - 100%'
        );
        if($key) return $array[$key];
        return $array;
    }
    
    public static function getFactorySizeDetails($key = 0){
        $array = array(
            '--- Please select ---',
            'Below 1,000 square meters',
            '1,000-3,000 square meters',
            '3,000-5,000 square meters',
            '5,000-10,000 square meters',
            '10,000-30,000 square meters',
            '30,000-50,000 square meters',
            '50,000-100,000 square meters',
            'Above 100,000 square meters'
        );
        if($key) return $array[$key];
        return $array;
    }
    
    public static function getAnnualPurchaseVolume($key = 0){
        $array = array(
            '--- Please select ---',
            '1% - 10%',
            '11% - 20%',
            '21% - 30%',
            '31% - 40%',
            '41% - 50%',
            '51% - 60%',
            '61% - 70%',
            '71% - 80%',
            '81% - 90%',
            '91% - 100%'
        );
        if($key) return $array[$key];
        return $array;
    }
    
    public static function getProductionLines($key = 0){
        for($i = 1; $i <= 10; $i++){
            $array[$i] = $i;
        }
        $array[] = 'Above 10';
        
        if($key) return $array[$key];
        return $array;
    }
    
    public static function getQualityControlDetails($key = 0){
        $array = array(
            '--- Please select ---',
            'In House',
            'Third Parties',
            'No',
        );
        
        if($key) return $array[$key];
        return $array;
    }
    
    public static function getNumberofStaff($key = 0){
        $array = array(
            '--- Please select ---',
            'Less than 5 People',
            '5 - 10 People',
            '11 - 20 People',
            '21 - 30 People',
            '31 - 40 People',
            '41 - 50 People',
            'Above 50 People'
        );
        
        if($key) return $array[$key];
        return $array;
    }
    
    public static function getLocations($key = 0) {
        $array = array(
            '0'=>'-- Please Select --',
            'Angola'=>'Angola',
            'Armenia'=>'Armenia',
            'Russia'=>'Russia',
            'United States'=>'United States'
        );
        if ($key) return $array[$key];
        return $array;
    }
    
    public static function getShippingTerms($key = 0) {
        $array = array(
            'EXW'=>'EXW',
            'FAS'=>'FAS',
            'FOB'=>'FOB',
            'FCA'=>'FCA',
            'CFR'=>'CFR',
            'CPT'=>'CPT',
            'CIF'=>'CIF',
            'CIP'=>'CIP',
            'DES'=>'DES',
            'DAF'=>'DAF',
            'DEQ'=>'DEQ',
            'DDP'=>'DDP',
            'DDU'=>'DDU'
        );
        if ($key) return $array[$key];
        return $array;
    }
    
    public static function getCurrencies($key = 0) {
        $array = array(
            'USD'=>'USD',
            'GBP'=>'GBP',
            'RMB'=>'RMB',
            'EUR'=>'EUR',
            'AUD'=>'AUD',
            'CAD'=>'CAD',
            'CHF'=>'CHF',
            'JPY'=>'JPY',
            'HKD'=>'HKD',
            'NZD'=>'NZD',
            'SGD'=>'SGD',
            'NTD'=>'NTD'
        );
        if ($key) return $array[$key];
        return $array;
    }
    
    public static function getPaymentTerms($key = 0) {
        $array = array(
            'L/C'=>'L/C',
            'T/T'=>'T/T',
            'D/P'=>'D/P',
            'Western Union'=>'Western Union',
            'Money Gram'=>'Money Gram'
        );
        if ($key) return $array[$key];
        return $array;
    }
    
    public static function getHelpdeskSections($key = 0) {
        $array = array(
            'Account'=>'Account',
            'Sales'=>'Sales'
        );
        if ($key) return $array[$key];
        return $array;
    }
}
