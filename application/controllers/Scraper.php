<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scraper extends CI_Controller {
  
	public function __construct(){
    parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
    
  }

  // http://makewebsmart.com/blog/scraping-library-for-codeigniter-framework/136
  public function tes(){
    $data = array();
    if(isset($_GET['url']))
    {
      $data['url'] = trim($_GET['url']);
      if(!empty( $data['url']))
      {
        $this->load->library('scraping');
//       $data['page'] = $this->scraping->page($url); // to scrape simple webpages
        $data['page'] = $this->scraping->shDom($data['url']); // to scrape complex webpages
      }else{
        $data['notice'] = 'URL is empty!!!';
      }
    }
    // $this->load->view('dashboard', $data);

    echo "<pre>",print_r($data),"</pre>";
  }


  public function google_autocom(){
    $url = "https://www.google.co.id/complete/search?"+
      "q=jual%20madu&cp=9&client=psy-ab&xssi=t&gs_ri=gws-wiz&hl=en-ID"+
      "&authuser=0&psi=rJo7X4rFMN2Z4-EPrquF-A8.1597741746321"+
      "&dpr=0.8999999761581421&ei=rJo7X4rFMN2Z4-EPrquF-A8";

    // $path = 'https://citramedika.com/info/c_info_simple.php?svc=update_bed_jadok'; // 2020.09.07
    // $res = $this->ws_rscm->ws_arr("base_url_post", "POST", $url, "");
    
    $this->load->library('curl');
    $res = $this->curl->ws_arr("base_url_post", "GET", $url, '');

		echo "<pre>",print_r($res),"</pre>";

  }
  
  
  public function socialblade(){
    // $url = 'https://www.socialblade.com/youtube/channel/UCHolywm_wVmGW-M_puUcY7Q';
    $url = 'https://www.socialblade.com/youtube/channel/UCHolywm_wVmGW-M_puUcY7Q?account=socialblade&section=default';
    // $url = 'https://www.detik.com';

    // // $path = 'https://citramedika.com/info/c_info_simple.php?svc=update_bed_jadok'; // 2020.09.07
    // // $res = $this->ws_rscm->ws_arr("base_url_post", "POST", $url, "");
    
    // $this->load->library('curl');
    // $res = $this->curl->ws_arr("base_url_post", "GET", $url, '');

		// // echo "<pre>",print_r($res),"</pre>";
    // echo $res;

    // +++++
    $header = array();
    $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
    $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
    $header[] =  "Cache-Control: max-age=0";
    $header[] =  "Connection: keep-alive";
    $header[] = "Keep-Alive: 300";
    $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
    $header[] = "Accept-Language: en-us,en;q=0.5";
    $header[] = "Pragma: "; // browsers keep this blank.

//     :authority: conf.lngtd.com
// :method: GET
// :path: /lngtd-config?account=socialblade&section=default
// :scheme: https
// accept: *\*
// accept-encoding: gzip, deflate, br
// accept-language: en-US,en;q=0.9,id;q=0.8
// cache-control: no-cache
// origin: https://socialblade.com
// pragma: no-cache
// referer: https://socialblade.com/
// sec-ch-ua: " Not;A Brand";v="99", "Google Chrome";v="91", "Chromium";v="91"
// sec-ch-ua-mobile: ?0
// sec-fetch-dest: empty
// sec-fetch-mode: cors
// sec-fetch-site: cross-site
// user-agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.106 Safari/537.36



    // +++++
    
    
    $ch = curl_init($url);

    // curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.2; en-US; rv:1.8.1.7) Gecko/20070914 Firefox/2.0.0.7');
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.106 Safari/537.36');
    curl_setopt($ch, CURLOPT_COOKIE, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

    // execute!
    $response = curl_exec($ch);

    // close the connection, release resources used
    curl_close($ch);

    // do anything you want with your response
    var_dump($response);
    

  }





}